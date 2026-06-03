<?php

use App\Http\Controllers\Admin\AdminReturnRequestController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\InvoiceController;
use App\Http\Controllers\User\ReturnRequestController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ThemeController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\ProductViewController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\RegisterUserController;
use App\Http\Controllers\EmailVerificationController;
use App\Http\Controllers\AuthenticatedSessionController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\KashierController;
use App\Http\Controllers\TwoFactorController;
use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\User\AddressController;
use App\Http\Controllers\User\OrderController as UserOrderController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\ReviewController as AdminReviewController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\CouponController as AdminCouponController;

// ══════════════════════════════════════════════════════════════
//  الصفحات العامة (بدون auth)
// ══════════════════════════════════════════════════════════════

Route::get('/',              [ProductViewController::class, 'welcome'])->name('welcome');
Route::get('/products',      [ProductViewController::class, 'index'])->name('products.index');
Route::get('/products/{id}', [ProductViewController::class, 'show'])->name('products.show');
Route::get('/brands/{slug}', [ProductViewController::class, 'brandShow'])->name('brands.show');
Route::post('/set-theme',    [ThemeController::class, 'set'])->name('theme.set');

// ──────────────────────────────────────────────────────────────
//  السلة — متاحة للجميع (guest + auth)
// ──────────────────────────────────────────────────────────────
Route::prefix('cart')->name('cart.')->group(function () {
    Route::get('/',               [CartController::class, 'index'])->name('index');
    Route::patch('/{productId}',  [CartController::class, 'update'])->name('update');
    Route::delete('/{productId}', [CartController::class, 'remove'])->name('remove');
    Route::delete('/',            [CartController::class, 'clear'])->name('clear');
});

// ──────────────────────────────────────────────────────────────
//  Kashier Webhook — خارج CSRF
// ──────────────────────────────────────────────────────────────
Route::post('/kashier/webhook', [KashierController::class, 'webhook'])->name('kashier.webhook');

// ══════════════════════════════════════════════════════════════
//  الضيوف فقط
// ══════════════════════════════════════════════════════════════
Route::middleware('guest')->group(function () {
    Route::get('/register',  [RegisterUserController::class, 'create'])->name('register.index');
    Route::post('/register', [RegisterUserController::class, 'store'])->name('register.store');

    Route::get('/login',  [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/login', [AuthenticatedSessionController::class, 'store'])->name('login.store');

    Route::get('/forgot-password',        [PasswordResetController::class, 'showForgotForm'])
        ->name('password.request');
    Route::post('/forgot-password',       [PasswordResetController::class, 'sendLink'])
        ->middleware('throttle:5,1')
        ->name('password.email');
    Route::get('/reset-password/{token}', [PasswordResetController::class, 'showResetForm'])
        ->name('password.reset');
    Route::post('/reset-password',        [PasswordResetController::class, 'updatePassword'])
        ->middleware('throttle:5,1')
        ->name('password.update');
});

// ══════════════════════════════════════════════════════════════
//  التحقق من الإيميل — auth بس (بدون verified)
// ══════════════════════════════════════════════════════════════
Route::middleware('auth')->prefix('verify-email')->name('verification.')->group(function () {
    Route::get('/',        [EmailVerificationController::class, 'showEmailForm'])->name('email');
    Route::post('/send',   [EmailVerificationController::class, 'sendOtp'])
        ->middleware('throttle:5,1')->name('send');
    Route::get('/otp',     [EmailVerificationController::class, 'showOtpForm'])->name('otp.form');
    Route::post('/verify', [EmailVerificationController::class, 'verifyOtp'])
        ->middleware('throttle:10,1')->name('verify');
    Route::post('/resend', [EmailVerificationController::class, 'resendOtp'])
        ->middleware('throttle:3,1')->name('resend');
});

// ══════════════════════════════════════════════════════════════
//  2FA — auth بس (بدون verified)
// ══════════════════════════════════════════════════════════════
Route::middleware('auth')->prefix('2fa')->name('2fa.')->group(function () {
    Route::get('/',        [TwoFactorController::class, 'show'])->name('show');
    Route::post('/send',   [TwoFactorController::class, 'send'])
        ->middleware('throttle:3,1')->name('send');
    Route::post('/verify', [TwoFactorController::class, 'verify'])
        ->middleware('throttle:5,1')->name('verify');
});

// ══════════════════════════════════════════════════════════════
//  Logout — auth بس بدون verified
// ══════════════════════════════════════════════════════════════
Route::middleware('auth')
    ->delete('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->name('logout');

// ══════════════════════════════════════════════════════════════
//  Checkout Success — auth بس (مش verified)
//  عشان الـ Kashier callback يقدر يوصله بعد الدفع
// ══════════════════════════════════════════════════════════════
Route::middleware('auth')
    ->get('/checkout/success/{order}', [CheckoutController::class, 'success'])
    ->name('checkout.success');

// ══════════════════════════════════════════════════════════════
//  المحمية — Auth + Verified
// ══════════════════════════════════════════════════════════════
Route::middleware(['auth', 'verified'])->group(function () {

    // ── السلة (إضافة) ─────────────────────────────────────────
    Route::post('/cart/{productId}/add', [CartController::class, 'add'])->name('cart.add');

    // ── Checkout ──────────────────────────────────────────────
    Route::prefix('checkout')->name('checkout.')->group(function () {
        Route::get('/',       [CheckoutController::class, 'index'])->name('index');
        Route::post('/order', [CheckoutController::class, 'placeOrder'])->name('order');
    });

    // ── Fast Buy ──────────────────────────────────────────────
    Route::post('/checkout/fast-buy/{product}', [CheckoutController::class, 'fastBuy'])
        ->name('checkout.fast-buy')
        ->middleware('throttle:10,1');

    // ── Kashier ───────────────────────────────────────────────
    Route::prefix('kashier')->name('kashier.')->group(function () {
        Route::get('/pay',      [KashierController::class, 'pay'])->name('pay');
        Route::get('/callback', [KashierController::class, 'callback'])->name('callback');
        Route::get('/cancel',   [KashierController::class, 'cancel'])->name('cancel');
    });

    // ── الكوبونات ─────────────────────────────────────────────
    Route::prefix('coupon')->name('coupon.')->group(function () {
        Route::post('/apply',    [CouponController::class, 'apply'])->name('apply');
        Route::delete('/remove', [CouponController::class, 'remove'])->name('remove');
    });

    // ── الملف الشخصي ──────────────────────────────────────────
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/',         [ProfileController::class, 'index'])->name('index');
        Route::put('/update',   [ProfileController::class, 'update'])->name('update');
        Route::put('/password', [ProfileController::class, 'updatePassword'])->name('password');
        Route::get('/reviews',  [ProfileController::class, 'reviews'])->name('reviews');
    });

    // ── العناوين ──────────────────────────────────────────────
    Route::resource('addresses', AddressController::class)->except(['show', 'create', 'edit']);
    Route::post('/addresses/{address}/default', [AddressController::class, 'setDefault'])
        ->name('addresses.default');

    // ── التقييمات ─────────────────────────────────────────────
    Route::prefix('products/{productId}/reviews')->name('product.reviews.')->group(function () {
        Route::post('/',   [ReviewController::class, 'store'])->name('store');
        Route::patch('/',  [ReviewController::class, 'update'])->name('update');
        Route::delete('/', [ReviewController::class, 'destroy'])->name('destroy');
    });

    // ── المفضلة ───────────────────────────────────────────────
    Route::prefix('wishlist')->name('wishlist.')->group(function () {
        Route::get('/',                            [WishlistController::class, 'index'])->name('index');
        Route::post('/{productId}/toggle',         [WishlistController::class, 'toggle'])->name('toggle');
        Route::post('/{productId}/save-for-later', [WishlistController::class, 'saveForLater'])->name('saveForLater');
        Route::delete('/{productId}',              [WishlistController::class, 'remove'])->name('remove');
        Route::delete('/',                         [WishlistController::class, 'clear'])->name('clear');
    });

    // ── الطلبات ───────────────────────────────────────────────
    Route::prefix('orders')->name('orders.')->group(function () {
        Route::get('/',                [UserOrderController::class, 'index'])->name('index');
        Route::get('/{order}',         [UserOrderController::class, 'show'])->name('show');
        Route::patch('/{order}/cancel',[UserOrderController::class, 'cancel'])->name('cancel'); // ✅
    });

    // ── الإرجاع ───────────────────────────────────────────────
    Route::prefix('returns')->name('returns.')->group(function () {
        Route::get('/',                                   [ReturnRequestController::class, 'index'])->name('index');
        Route::get('/orders/{order}/items/{item}/create', [ReturnRequestController::class, 'create'])->name('create');
        Route::post('/orders/{order}/items/{item}',       [ReturnRequestController::class, 'store'])->name('store');
        Route::get('/{return}',                           [ReturnRequestController::class, 'show'])->name('show');
    });

    // ══════════════════════════════════════════════════════════
    //  Admin — AdminMiddleware + two_factor
    // ══════════════════════════════════════════════════════════
    Route::middleware([\App\Http\Middleware\AdminMiddleware::class, 'two_factor'])
        ->prefix('admin')
        ->name('admin.')
        ->group(function () {

            Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');

            // ── المستخدمين ────────────────────────────────────
            Route::prefix('users')->name('users.')->group(function () {
                Route::get('/',                       [AdminUserController::class, 'index'])->name('index');
                Route::get('/{user}',                 [AdminUserController::class, 'show'])->name('show');
                Route::get('/{user}/activity',        [AdminUserController::class, 'activity'])->name('activity');
                Route::patch('/{user}/toggle-status', [AdminUserController::class, 'toggleStatus'])->name('toggle-status');
                Route::delete('/{user}',              [AdminUserController::class, 'destroy'])->name('destroy');
            });

            // ── الإشعارات ──────────────────────────────────────
            Route::prefix('notifications')->name('notifications.')->group(function () {
                Route::get('/count',      [AdminController::class, 'notificationsCount'])->name('count');
                Route::get('/fetch',      [AdminController::class, 'fetchNotifications'])->name('fetch');
                Route::post('/{id}/read', [AdminController::class, 'markAsRead'])->name('read');
                Route::post('/read-all',  [AdminController::class, 'markAllAsRead'])->name('readAll');
            });

            // ── التقييمات ──────────────────────────────────────
            Route::prefix('reviews')->name('reviews.')->group(function () {
                Route::get('/',                   [AdminReviewController::class, 'index'])->name('index');
                Route::patch('/{review}/approve', [AdminReviewController::class, 'approve'])->name('approve');
                Route::patch('/{review}/reject',  [AdminReviewController::class, 'reject'])->name('reject');
                Route::delete('/{review}',        [AdminReviewController::class, 'destroy'])->name('destroy');
            });

            // ── الماركات ───────────────────────────────────────
            Route::post('brands/bulk-activate',  [BrandController::class, 'bulkActivate'])->name('brands.bulk-activate');
            Route::post('brands/bulk-hide',      [BrandController::class, 'bulkHide'])->name('brands.bulk-hide');
            Route::delete('brands/bulk-destroy', [BrandController::class, 'bulkDestroy'])->name('brands.bulk-destroy');
            Route::resource('brands', BrandController::class)->except(['show']);
            Route::patch('brands/{brand}/toggle-status', [BrandController::class, 'toggleStatus'])
                ->name('brands.toggle-status');

            // ── الأقسام ────────────────────────────────────────
            Route::post('categories/bulk-activate',  [AdminCategoryController::class, 'bulkActivate'])->name('categories.bulk-activate');
            Route::post('categories/bulk-hide',      [AdminCategoryController::class, 'bulkHide'])->name('categories.bulk-hide');
            Route::delete('categories/bulk-destroy', [AdminCategoryController::class, 'bulkDestroy'])->name('categories.bulk-destroy');
            Route::resource('categories', AdminCategoryController::class);
            Route::patch('categories/{category}/toggle-status', [AdminCategoryController::class, 'toggleStatus'])
                ->name('categories.toggle-status');

            // ── المنتجات ───────────────────────────────────────
            Route::resource('products', ProductController::class)->except(['show']);
            Route::patch('products/{product}/toggle-status', [ProductController::class, 'toggleStatus'])
                ->name('products.toggle-status');

            // ── الطلبات ────────────────────────────────────────
            Route::resource('orders', AdminOrderController::class)->only(['index', 'show']);
            Route::patch('/orders/{order}/status', [AdminOrderController::class, 'updateStatus'])
                ->name('orders.updateStatus');

            // ── الفواتير ───────────────────────────────────────
            Route::get('/orders/{order}/invoice/download', [InvoiceController::class, 'download'])
                ->name('orders.invoice.download');
            Route::get('/orders/{order}/invoice/stream', [InvoiceController::class, 'stream'])
                ->name('orders.invoice.stream');

            // ── التقارير ───────────────────────────────────────
            Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');

            // ── الكوبونات ──────────────────────────────────────
            Route::resource('coupons', AdminCouponController::class);
            Route::patch('coupons/{coupon}/toggle-status', [AdminCouponController::class, 'toggleStatus'])
                ->name('coupons.toggle-status');

            // ── الإرجاع ────────────────────────────────────────
            Route::prefix('returns')->name('returns.')->group(function () {
                Route::get('/',                  [AdminReturnRequestController::class, 'index'])->name('index');
                Route::get('/{return}',          [AdminReturnRequestController::class, 'show'])->name('show');
                Route::patch('/{return}/status', [AdminReturnRequestController::class, 'updateStatus'])->name('updateStatus');
            });
        });
});
