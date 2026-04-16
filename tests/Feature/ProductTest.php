<?php

use App\Models\User;
use Illuminate\Http\UploadedFile;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;


it('can view products page', function () {
    $user = User::factory()->create(['is_admin' => true]);
    /** @var \App\Models\User $user */
    $this->actingAs($user);
    $response = $this->get(route('admin.products.index'));

    $response->assertStatus(200);
    $response->assertViewIs('products.index');
});

it ('can store a new product with brand and images',function (){
    $user = User::factory()->create(['is_admin' => true]);
    $brand = Brand::factory()->create([
        'name' => 'Test Brand',
        'slug' => 'test-brand',
    ]);
    $category = Category::factory()->create([
        'name' => 'Test Category',
        'slug' => 'test-category',
    ]);

    Storage::fake('public');
    /** @var \App\Models\User $user */
    $response = $this->actingAs($user)->post(route('admin.products.store'), [
        'name' => 'Test Product',
        'description' => 'This is a test product.',
        'price' => 99.99,
        'stock' => 10,
        'main_image'  => UploadedFile::fake()->image('product.jpg'),
        'brand_id' => $brand->id,
        'category_id' => $category->id,

    ]);
    $response->assertSessionHasNoErrors();

    $response->assertRedirect(route('admin.products.index'));
    $response->assertSessionHas('success', 'تم الحفظ بنجاح، يمكنك إضافة منتج آخر الآن');
    $this->assertDatabaseHas('products', [
        'name' => 'Test Product',
        'description' => 'This is a test product.',
        'price' => 99.99,
        'stock' => 10,
        'brand_id' => $brand->id,
        'category_id' => $category->id,

    ]);

    // 2. تأكد من أن الصورة تم رفعها فعلاً في الـ Storage
    $product = \App\Models\Product::where('name', 'Test Product')->first();
expect($product->image_url)->not->toBeNull();
    Storage::disk('public')->assertExists($product->image_url);

});
