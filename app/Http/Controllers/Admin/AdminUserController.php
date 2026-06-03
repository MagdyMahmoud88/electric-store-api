<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserActivityLog;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminUserController extends Controller
{
    // ══════════════════════════════════════════════════════════════
    //  index — قائمة المستخدمين مع بحث + فلترة + ترقيم
    //  GET /admin/users
    // ══════════════════════════════════════════════════════════════
    public function index(Request $request): View
    {
        $request->validate([
            'search'   => ['nullable', 'string', 'max:100'],
            'status'   => ['nullable', 'in:active,inactive'],
            'verified' => ['nullable', 'in:yes,no'],
            'role'     => ['nullable', 'in:user,admin'],
            'sort'     => ['nullable', 'in:latest,oldest,name,orders,spent'],
        ]);

        $query = User::query()
            ->withCount(['orders', 'reviews', 'wishlists'])
            ->withSum('orders', 'total');

        // ── بحث ──────────────────────────────────────────────────
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name',  'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // ── فلاتر ────────────────────────────────────────────────
        if ($request->filled('status')) {
            $query->where('is_active', $request->input('status') === 'active');
        }

        if ($request->filled('verified')) {
            $request->input('verified') === 'yes'
                ? $query->whereNotNull('email_verified_at')
                : $query->whereNull('email_verified_at');
        }

        if ($request->filled('role')) {
            $query->where('role', $request->input('role'));
        }

        // ── ترتيب ────────────────────────────────────────────────
        match ($request->input('sort', 'latest')) {
            'oldest'  => $query->oldest(),
            'name'    => $query->orderBy('name'),
            'orders'  => $query->orderByDesc('orders_count'),
            'spent'   => $query->orderByDesc('orders_sum_total'),
            default   => $query->latest(),
        };

        $users = $query->paginate(20)->withQueryString();

        // ── إحصائيات سريعة للـ header ────────────────────────────
        $stats = [
            'total'      => User::count(),
            'active'     => User::where('is_active', true)->count(),
            'inactive'   => User::where('is_active', false)->count(),
            'unverified' => User::whereNull('email_verified_at')->count(),
        ];

        return view('admin.users.index', compact('users', 'stats'));
    }

    // ══════════════════════════════════════════════════════════════
    //  show — بروفايل مستخدم كامل مع سجل النشاط
    //  GET /admin/users/{user}
    // ══════════════════════════════════════════════════════════════
    public function show(User $user, Request $request): View
    {
        // كل الإحصائيات في query واحدة
        $user->loadCount(['orders', 'reviews', 'wishlists', 'returnRequests'])
            ->loadSum('orders', 'total');

        // آخر 5 طلبات
        $recentOrders = $user->orders()
            ->with('items.product')
            ->latest()
            ->take(5)
            ->get();

        // آخر 5 إرجاعات
        $returnRequests = $user->returnRequests()
            ->with('orderItem.product', 'order')
            ->latest()
            ->take(5)
            ->get();

        // آخر 5 تقييمات
        $reviews = $user->reviews()
            ->with('product')
            ->latest()
            ->take(5)
            ->get();

        // ── سجل النشاط مع فلترة بالنوع ───────────────────────────
        $activityQuery = $user->activityLogs()->latest();

        if ($type = $request->input('activity_type')) {
            $activityQuery->where('type', $type);
        }

        $activityLogs    = $activityQuery->paginate(15, ['*'], 'activity_page')
            ->withQueryString();
        $activityTypes   = UserActivityLog::forUser($user->id)
            ->select('type')
            ->distinct()
            ->pluck('type');

        return view('admin.users.show', compact(
            'user',
            'recentOrders',
            'returnRequests',
            'reviews',
            'activityLogs',
            'activityTypes',
        ));
    }

    // ══════════════════════════════════════════════════════════════
    //  activity — AJAX endpoint لتحميل المزيد من النشاط
    //  GET /admin/users/{user}/activity
    // ══════════════════════════════════════════════════════════════
    public function activity(User $user, Request $request): JsonResponse
    {
        $logs = $user->activityLogs()
            ->when($request->input('type'), fn($q, $t) => $q->where('type', $t))
            ->latest()
            ->paginate(20);

        return response()->json([
            'data'         => $logs->items(),
            'current_page' => $logs->currentPage(),
            'last_page'    => $logs->lastPage(),
        ]);
    }

    // ══════════════════════════════════════════════════════════════
    //  toggleStatus — تفعيل / تعطيل الحساب
    //  PATCH /admin/users/{user}/toggle-status
    // ══════════════════════════════════════════════════════════════
    public function toggleStatus(User $user): JsonResponse|RedirectResponse
    {
        // ⚠️ حماية حسابات الـ Admin
        if ($user->isAdmin()) {
            $error = 'لا يمكن تعطيل حساب مدير.';
            return request()->expectsJson()
                ? response()->json(['success' => false, 'message' => $error], 403)
                : back()->with('error', $error);
        }

        $user->update(['is_active' => ! $user->is_active]);
        $user->refresh();

        $action  = $user->is_active ? 'تفعيل' : 'تعطيل';
        $message = "تم {$action} حساب {$user->name} بنجاح.";

        if (request()->expectsJson()) {
            return response()->json([
                'success'   => true,
                'is_active' => $user->is_active,
                'message'   => $message,
            ]);
        }

        return back()->with('success', $message);
    }

    // ══════════════════════════════════════════════════════════════
    //  destroy — حذف الحساب نهائياً
    //  DELETE /admin/users/{user}
    // ══════════════════════════════════════════════════════════════
    public function destroy(User $user): RedirectResponse
    {
        // ⚠️ حماية الـ Admin
        if ($user->isAdmin()) {
            return back()->with('error', 'لا يمكن حذف حساب مدير.');
        }

        // ⚠️ حماية من حذف يوزر عنده طلبات نشطة
        if ($user->hasActiveOrders()) {
            return back()->with('error', 'لا يمكن حذف المستخدم لوجود طلبات نشطة.');
        }

        $userName = $user->name;
        $user->delete();

        return redirect()
            ->route('admin.users.index')
            ->with('success', "تم حذف حساب {$userName} بنجاح.");
    }
}
