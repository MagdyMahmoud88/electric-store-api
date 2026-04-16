<?php
use App\Models\Brand;
use App\Models\User; // تأكد من استدعاء موديل المستخدم
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

it('can store a new brand with a logo', function () {
    $this->withoutExceptionHandling();
    // 1. إنشاء مستخدم وهمي
    $user = User::factory()->create(['is_admin' => true]); // تأكد من أن المستخدم لديه صلاحيات إدارية

    // 2. تسجيل الدخول بهذا المستخدم
    $this->actingAs($user);

    Storage::fake('public');

    $brandData = [
        'name'        => 'فولت إضاءة',
        'description' => 'وصف تجريبي للماركة',
        'is_active'   => true,
        'logo'        => UploadedFile::fake()->image('brand-logo.png')
    ];

    // إرسال الطلب
    $response = $this->post(route('admin.brands.store'), $brandData);

    // الآن سيعمل التحويل بنجاح لأنك "مسجل دخول"
    $response->assertRedirect(route('admin.brands.index'));

    $this->assertDatabaseHas('brands', [
        'name' => 'فولت إضاءة',
    ]);
});


it('can update an existing brand' , function (){
$user =User::factory()->create(['is_admin' => true]);
$this->actingAs($user);

$brand = Brand::factory()->create([
    'name' => 'فولت إضاءة',
    'description' => 'وصف تجريبي للماركة',
    'is_active' => true,
 //   'logo' => UploadedFile::fake()->image('new-logo.png')
]);
$response = $this->put(route('admin.brands.update',$brand), [
    'name' => 'فولت إضاءة - تحديث',
    'description' => 'وصف محدث للماركة',
    'is_active' => false,
 //   'logo' => UploadedFile::fake()->image('new-logo.png')
]);
$response->assertRedirect(route('admin.brands.index'));
$this->assertDatabaseHas('brands', [
    'id' => $brand->id,
    'name' => 'فولت إضاءة - تحديث',
    'description' => 'وصف محدث للماركة',
    'is_active' => false,
//    'logo' => UploadedFile::fake()->image('new-logo.png')
]);
});

it('can delete a brand successfully as an admin', function () {
    $this->withoutExceptionHandling();
    // 1. تسجيل الدخول كأدمن
 $user = User::factory()->create(['is_admin' => true]);
    $this->actingAs($user);

    $brand = Brand::factory()->create();

    // نحدد أننا نقف في صفحة الفهرس قبل إرسال طلب الحذف
    $response = $this->from(route('admin.brands.index'))
                     ->delete(route('admin.brands.destroy', $brand));

    // الآن back() ستفهم أنها يجب أن تعود لصفحة الفهرس
    $response->assertRedirect(route('admin.brands.index'));

    // التأكد من رسالة النجاح في الـ Session
    $response->assertSessionHas('success', 'تم حذف الماركة بنجاح');

   $this->assertSoftDeleted($brand);
});
