<?php

namespace App\Policies;

use App\Models\Order;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

/**
 * OrderPolicy
 *
 * بتتسجل في AuthServiceProvider:
 *
 *   protected $policies = [
 *       Order::class => OrderPolicy::class,
 *   ];
 *
 * الاستخدام في الـ Controller:
 *
 *   public function show(Order $order)
 *   {
 *       $this->authorize('view', $order);
 *       ...
 *   }
 *
 * أو في الـ Route عن طريق Route Model Binding + Policy Auto-Discovery
 * لو Model واسمها Order والـ Policy واسمها OrderPolicy Laravel بيعرف يربطهم.
 */
class OrderPolicy
{
    use HandlesAuthorization;

    /**
     * الأدمن يشوف كل حاجة — User يشوف orders بتاعته بس.
     */
    public function view(User $user, Order $order): bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        return $user->id === $order->user_id;
    }

    /**
     * إنشاء Order — أي user مسجّل يقدر.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * تعديل Order — الأدمن بس.
     */
    public function update(User $user, Order $order): bool
    {
        return $user->isAdmin();
    }

    /**
     * حذف Order — الأدمن بس.
     */
    public function delete(User $user, Order $order): bool
    {
        return $user->isAdmin();
    }
}
