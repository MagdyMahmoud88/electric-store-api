<?php

namespace App\Services;

use App\Models\User;
use App\Models\UserActivityLog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Request;

class ActivityLogger
{
    // ══════════════════════════════════════════════════════════
    //  Core — الميثود الأساسية اللي كل حاجة بتمشي منها
    // ══════════════════════════════════════════════════════════

    public static function log(
        User   $user,
        string $type,
        string $description,
        ?Model $loggable = null,
        array  $metadata = [],
    ): UserActivityLog {
        return UserActivityLog::create([
            'user_id'       => $user->id,
            'type'          => $type,
            'description'   => $description,
            'loggable_type' => $loggable ? get_class($loggable) : null,
            'loggable_id'   => $loggable?->getKey(),
            'metadata'      => $metadata ?: null,
            'ip_address'    => Request::ip(),
            'user_agent'    => Request::userAgent(),
            'url'           => Request::fullUrl(),
        ]);
    }

    // ══════════════════════════════════════════════════════════
    //  Auth Events
    // ══════════════════════════════════════════════════════════

    public static function login(User $user): void
    {
        static::log(
            user:        $user,
            type:        UserActivityLog::TYPE_LOGIN,
            description: 'تسجيل دخول ناجح',
        );
    }

    public static function logout(User $user): void
    {
        static::log(
            user:        $user,
            type:        UserActivityLog::TYPE_LOGOUT,
            description: 'تسجيل خروج',
        );
    }

    public static function loginFailed(User $user): void
    {
        static::log(
            user:        $user,
            type:        UserActivityLog::TYPE_LOGIN_FAILED,
            description: 'محاولة دخول فاشلة',
            metadata:    ['email' => $user->email],
        );
    }

    public static function passwordReset(User $user): void
    {
        static::log(
            user:        $user,
            type:        UserActivityLog::TYPE_PASSWORD_RESET,
            description: 'إعادة تعيين كلمة المرور',
        );
    }

    public static function emailVerified(User $user): void
    {
        static::log(
            user:        $user,
            type:        UserActivityLog::TYPE_EMAIL_VERIFIED,
            description: 'تم التحقق من البريد الإلكتروني',
        );
    }

    // ══════════════════════════════════════════════════════════
    //  Order Events
    // ══════════════════════════════════════════════════════════

    public static function orderPlaced(User $user, Model $order): void
    {
        static::log(
            user:        $user,
            type:        UserActivityLog::TYPE_ORDER_PLACED,
            description: "تم إنشاء طلب #{$order->id}",
            loggable:    $order,
            metadata:    [
                'total'      => $order->total_price,
                'items'      => $order->items()->count(),
                'payment'    => $order->payment_method ?? null,
            ],
        );
    }

    public static function orderCancelled(User $user, Model $order): void
    {
        static::log(
            user:        $user,
            type:        UserActivityLog::TYPE_ORDER_CANCELLED,
            description: "إلغاء طلب #{$order->id}",
            loggable:    $order,
            metadata:    ['total' => $order->total_price],
        );
    }

    public static function orderReturned(User $user, Model $order): void
    {
        static::log(
            user:        $user,
            type:        UserActivityLog::TYPE_ORDER_RETURNED,
            description: "طلب إرجاع للطلب #{$order->id}",
            loggable:    $order,
        );
    }

    // ══════════════════════════════════════════════════════════
    //  Review Events
    // ══════════════════════════════════════════════════════════

    public static function reviewAdded(User $user, Model $review): void
    {
        static::log(
            user:        $user,
            type:        UserActivityLog::TYPE_REVIEW_ADDED,
            description: "إضافة تقييم للمنتج #{$review->product_id}",
            loggable:    $review,
            metadata:    ['rating' => $review->rating],
        );
    }

    public static function reviewUpdated(User $user, Model $review): void
    {
        static::log(
            user:        $user,
            type:        UserActivityLog::TYPE_REVIEW_UPDATED,
            description: "تعديل تقييم للمنتج #{$review->product_id}",
            loggable:    $review,
            metadata:    ['rating' => $review->rating],
        );
    }

    public static function reviewDeleted(User $user, int $productId): void
    {
        static::log(
            user:        $user,
            type:        UserActivityLog::TYPE_REVIEW_DELETED,
            description: "حذف تقييم للمنتج #{$productId}",
        );
    }

    // ══════════════════════════════════════════════════════════
    //  Wishlist Events
    // ══════════════════════════════════════════════════════════

    public static function wishlistAdded(User $user, int $productId): void
    {
        static::log(
            user:        $user,
            type:        UserActivityLog::TYPE_WISHLIST_ADDED,
            description: "إضافة منتج #{$productId} للمفضلة",
            metadata:    ['product_id' => $productId],
        );
    }

    public static function wishlistRemoved(User $user, int $productId): void
    {
        static::log(
            user:        $user,
            type:        UserActivityLog::TYPE_WISHLIST_REMOVED,
            description: "حذف منتج #{$productId} من المفضلة",
            metadata:    ['product_id' => $productId],
        );
    }

    // ══════════════════════════════════════════════════════════
    //  Profile Events
    // ══════════════════════════════════════════════════════════

    public static function profileUpdated(User $user, array $changed = []): void
    {
        static::log(
            user:        $user,
            type:        UserActivityLog::TYPE_PROFILE_UPDATED,
            description: 'تحديث بيانات الملف الشخصي',
            metadata:    ['changed_fields' => array_keys($changed)],
        );
    }

    public static function passwordChanged(User $user): void
    {
        static::log(
            user:        $user,
            type:        UserActivityLog::TYPE_PASSWORD_CHANGED,
            description: 'تغيير كلمة المرور',
        );
    }

    public static function addressAdded(User $user, Model $address): void
    {
        static::log(
            user:        $user,
            type:        UserActivityLog::TYPE_ADDRESS_ADDED,
            description: 'إضافة عنوان جديد',
            loggable:    $address,
        );
    }
}
