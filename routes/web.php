<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ThemeController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\ProductViewController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\RegisterUserController;
use App\Http\Controllers\EmailVerificationController;
use App\Http\Controllers\AuthenticatedSessionController;

// مسارات المستخدم (User & Admin)
use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\User\AddressController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\ReviewController as AdminReviewController;

// ─── المسارات العامة (الجميع) ─────────────────────────────
Route::get('/', [ProductViewController::class, 'welcome'])->name('welcome');
Route::get('/products', [ProductViewController::class, 'index'])->name('products.index');
Route::get('/products/{id}', [ProductViewController::class, 'show'])->name('products.show');
Route::get('/brands/{slug}', [BrandController::class, 'show'])->name('brands.show');
Route::post('/set-theme', [ThemeController::class, 'set'])->name('theme.set');

// ─── السلة (Cart) ─────────────────────────────────────────
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/{productId}/add', [CartController::class, 'add'])->name('cart.add');
Route::patch('/cart/{productId}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/{productId}', [CartController::class, 'remove'])->name('cart.remove');
Route::delete('/cart', [CartController::class, 'clear'])->name('cart.clear');

// ─── الضيوف فقط (Guest) ───────────────────────────────────
Route::middleware('guest')->group(function () {
    // التسجيل
    Route::get('/register', [RegisterUserController::class, 'index'])->name('register.index');
    Route::post('/register', [RegisterUserController::class, 'store'])->name('register.store');

    // تسجيل الدخول
    Route::get('/login', [AuthenticatedSessionController::class, 'index'])->name('login.index');
    Route::post('/login', [AuthenticatedSessionController::class, 'store'])->name('login.store');

    // نسيت كلمة السر
    Route::get('/forgot-password', [PasswordResetController::class, 'showForgotForm'])->name('password.request');
    Route::post('/forgot-password', [PasswordResetController::class, 'sendLink'])->middleware('throttle:5,1')->name('password.email');
    Route::get('/reset-password/{token}', [PasswordResetController::class, 'showResetForm'])->name('password.reset');
    Route::post('/reset-password', [PasswordResetController::class, 'updatePassword'])->middleware('throttle:5,1')->name('password.update');
});

// ─── التحقق من البريد الإلكتروني ─────────────────────────
Route::prefix('verify-email')->name('verification.')->group(function () {
    Route::get('/', [EmailVerificationController::class, 'showEmailForm'])->name('email');
    Route::post('/send', [EmailVerificationController::class, 'sendOtp'])->middleware('throttle:5,1')->name('send');
    Route::get('/otp', [EmailVerificationController::class, 'showOtpForm'])->name('otp.form');
    Route::post('/verify', [EmailVerificationController::class, 'verifyOtp'])->middleware('throttle:10,1')->name('verify');
    Route::post('/resend', [EmailVerificationController::class, 'resendOtp'])->middleware('throttle:3,1')->name('resend');
});

// ─── المسارات المحمية (Auth) ──────────────────────────────
Route::middleware('auth')->group(function () {

    // الملف الشخصي (Profile) والعناوين
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'index'])->name('index');
        Route::put('/update', [ProfileController::class, 'update'])->name('update');
        Route::put('/password', [ProfileController::class, 'updatePassword'])->name('password');
    });
    Route::resource('addresses', AddressController::class);

    // التقييمات (Reviews)
    Route::prefix('products/{productId}/reviews')->name('product.reviews.')->group(function () {
        Route::post('/', [ReviewController::class, 'store'])->name('store');
        Route::patch('/', [ReviewController::class, 'update'])->name('update');
        Route::delete('/', [ReviewController::class, 'destroy'])->name('destroy');
    });

    // المفضلة (Wishlist)
    Route::prefix('wishlist')->name('wishlist.')->group(function () {
        Route::get('/', [WishlistController::class, 'index'])->name('index');
        Route::post('/{productId}/toggle', [WishlistController::class, 'toggle'])->name('toggle');
        Route::delete('/{productId}', [WishlistController::class, 'remove'])->name('remove');
        Route::delete('/', [WishlistController::class, 'clear'])->name('clear');
    });

    Route::delete('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout.destroy');

    // ─── لوحة تحكم الأدمن (Admin) ──────────────────────────
    Route::middleware(\App\Http\Middleware\AdminMiddleware::class)
        ->prefix('admin')
        ->name('admin.')
        ->group(function () {

            Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');

            // مراجعة التقييمات من قبل الأدمن
            Route::prefix('reviews')->name('reviews.')->group(function () {
                Route::get('/', [AdminReviewController::class, 'index'])->name('index');
                Route::patch('/{review}/approve', [AdminReviewController::class, 'approve'])->name('approve');
                Route::patch('/{review}/reject', [AdminReviewController::class, 'reject'])->name('reject');
                Route::delete('/{review}', [AdminReviewController::class, 'destroy'])->name('destroy');
            });

            Route::resource('brands', BrandController::class)->except(['show']);
            Route::patch('brands/{brand}/toggle-status', [BrandController::class, 'toggleStatus'])->name('brands.toggle-status');

            Route::resource('categories', CategoryController::class);
            Route::patch('/categories/{category}/toggle-status', [CategoryController::class, 'toggleStatus'])->name('categories.toggleStatus');

            Route::resource('products', ProductViewController::class)->except(['show']);

            Route::resource('orders', OrderController::class)->only(['index', 'show']);
            Route::patch('/orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.updateStatus');
            Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
        });
});
