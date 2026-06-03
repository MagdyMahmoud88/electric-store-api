# AGENTS.md - Electric Store API

## Overview
Laravel 12 e-commerce application with Arabic UI, featuring product catalog, cart, checkout, user reviews, admin panel, and Kashier payment integration. Uses Pest for testing, Vite/Tailwind/DaisyUI for frontend.

## Architecture
- **Hybrid Cart System**: Database-backed for authenticated users, session-based for guests
- **OTP Email Verification**: Custom implementation replacing Laravel's standard email verification
- **Payment Integration**: Kashier gateway with webhook/callback handling
- **Review Moderation**: Admin approval system for user reviews
- **Admin Panel**: CRUD operations for products, categories, brands, orders, coupons

## Key Components
- `app/Models/`: Product, User, Order, CartItem, Review, Category, Brand, Coupon, etc.
- `app/Http/Controllers/`: Separate namespaces for user-facing and admin controllers
- `routes/web.php`: Main application routes with auth/guest/admin middleware groups
- `database/migrations/`: Standard Laravel migrations with foreign key constraints

## Development Workflow
- **Setup**: `composer run setup` (install deps, generate key, migrate, npm install/build)
- **Development**: `composer run dev` (concurrent: artisan serve, queue:listen, npm run dev)
- **Testing**: `composer run test` (runs Pest tests with config clear)
- **Database**: SQLite for development, configured in `phpunit.xml` for in-memory testing

## Patterns & Conventions

### Query Building
Use `when()` for conditional filters, `whereHas()` for related model constraints:
```php
$products = Product::with(['category', 'brand'])
    ->whereHas('category', fn($q) => $q->where('status', 'active'))
    ->when($request->search, fn($q) => $q->where('name', 'like', '%' . $request->search . '%'))
    ->paginate(12);
```

### Cart Management
Hybrid implementation - check auth status to determine storage:
```php
private function getCart(): array {
    if (Auth::check()) {
        return CartItem::with('product')->where('user_id', Auth::id())->get()->mapWithKeys(...)->toArray();
    }
    return session('cart', []);
}
```

### Image Handling
Store in `storage/app/public/products/`, access via `asset('storage/' . $path)`:
```php
$validated['image_url'] = $request->file('main_image')->store('products', 'public');
Storage::disk('public')->delete($oldPath);
```

### Payment Security
Generate HMAC-SHA256 hash for Kashier requests, verify in callbacks/webhooks:
```php
$hash = hash_hmac('sha256', "/?payment={$mid}.{$orderId}.{$amount}.{$currency}", $secret, false);
```

### Email Verification
Custom OTP system with rate limiting and session storage:
- Store hashed OTP in `EmailVerificationOtp` model with expiration
- Rate limit sends/verifies using `RateLimiter` facade
- Use `password_verify()` for OTP validation

### Product Pricing
Discount calculation in model accessor:
```php
public function getDiscountedPriceAttribute() {
    return $this->price - ($this->price * $this->discount / 100);
}
```

### Admin Operations
Toggle status fields for soft-enable/disable:
```php
public function toggleStatus(Request $request, Brand $brand) {
    $brand->update(['is_active' => !$brand->is_active]);
    return back()->with('success', 'تم تحديث الحالة');
}
```

### Response Handling
Use `back()` redirects with flash messages for form submissions:
```php
return back()->with('success', 'تم الحفظ بنجاح');
return back()->withErrors(['field' => 'خطأ في البيانات']);
```

### Validation & Requests
Use Form Request classes for complex validation:
```php
public function store(ProductRequest $request) {
    $validated = $request->validated();
    // ... process
}
```

### Middleware
Custom `AdminMiddleware` for admin routes, applied at route group level.

### Testing
Pest framework with standard Laravel test structure. Use in-memory SQLite.

### Frontend
- Vite for asset compilation
- Tailwind CSS + DaisyUI components
- Axios for API calls (if any)
- Arabic RTL support

### External Services
- **Kashier**: Payment processing (config in `config/kashier.php`)
- **Resend**: Email delivery via `VerifyEmailOtpMail` mailable
- **Intervention Image**: Image manipulation (composer dependency)

### File Structure Notes
- Controllers separated by concern: user-facing in root namespace, admin in `Admin\` namespace
- Models include relationship methods and custom accessors
- Views use Arabic text and RTL layout
- Migrations use `constrained()` for foreign keys with `nullOnDelete()`

### Common Gotchas
- Cart quantities validated against product stock
- Reviews require admin approval to display
- Orders generate unique order numbers for payment reference
- Email verification uses session to track verification flow
- Product images stored in public disk, served via asset helper</content>
<parameter name="filePath">C:\Users\USER\Herd\electric-store-api\AGENTS.md
