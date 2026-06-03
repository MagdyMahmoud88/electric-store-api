<?php

namespace App\Providers;

use App\Models\Order;
use App\Policies\OrderPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class Authserviceprovider extends ServiceProvider
{
    /**
     * ربط الـ Models بالـ Policies بتاعتها.
     *
     * Laravel بيستخدم الـ policies دي تلقائياً لما تعمل:
     *   $this->authorize('view', $order);
     */
    protected $policies = [
        Order::class => OrderPolicy::class,
    ];

    public function boot(): void
    {
        $this->registerPolicies();
    }
}
