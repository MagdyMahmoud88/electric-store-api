<?php if (isset($component)) { $__componentOriginal23a33f287873b564aaf305a1526eada4 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal23a33f287873b564aaf305a1526eada4 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layout','data' => ['title' => 'تفاصيل القسم']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'تفاصيل القسم']); ?>
    <div class="p-6 bg-base-200 min-h-screen" dir="rtl" style="font-family:'Cairo', sans-serif;">
        <div class="max-w-4xl mx-auto">

            
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h1 class="text-2xl font-bold"><?php echo e($category->name); ?></h1>
                    <p class="text-sm text-gray-500 mt-1">الرابط: /categories/<?php echo e($category->slug); ?></p>
                </div>
                <div class="flex gap-2">
                    <a href="<?php echo e(route('admin.categories.index')); ?>" class="btn btn-outline btn-sm">← عودة</a>
                    <a href="<?php echo e(route('admin.categories.edit', $category)); ?>" class="btn btn-primary btn-sm">تعديل القسم</a>
                </div>
            </div>

            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                <div class="card bg-base-100 p-4 border border-base-300 flex flex-row items-center justify-between shadow-sm">
                    <div>
                        <span class="text-gray-500 text-sm">إجمالي المنتجات</span>
                        <h3 class="text-2xl font-bold mt-1"><?php echo e($category->products_count); ?> منتج</h3>
                    </div>
                    <div class="p-3 bg-primary/10 text-primary rounded-lg text-xl">📦</div>
                </div>

                <div class="card bg-base-100 p-4 border border-base-300 flex flex-row items-center justify-between shadow-sm">
                    <div>
                        <span class="text-gray-500 text-sm">الحالة الحالية</span>
                        <h3 class="text-2xl font-bold mt-1">
                            <?php if($category->status === 'active'): ?>
                                <span class="text-success text-lg">● نشط</span>
                            <?php else: ?>
                                <span class="text-error text-lg">● مخفي</span>
                            <?php endif; ?>
                        </h3>
                    </div>
                    <div class="p-3 bg-base-200 rounded-lg text-xl">🔔</div>
                </div>
            </div>

            
            <div class="card bg-base-100 shadow-sm border border-base-300">
                <div class="p-4 border-b border-base-300">
                    <h3 class="font-bold text-lg">أحدث المنتجات المضافة في هذا القسم</h3>
                </div>

                <div class="overflow-x-auto">
                    <table class="table w-full text-right">
                        <thead>
                        <tr>
                            <th>المنتج</th>
                            <th>السعر</th>
                            <th>المخزن</th>
                            <th>تاريخ الإضافة</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $category->products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td>
                                    <div class="flex items-center gap-3">
                                        <img src="<?php echo e(asset('storage/' . $product->image_url)); ?>" class="w-10 h-10 rounded-lg object-cover" onerror="this.src='/images/placeholder.png'">
                                        <span class="font-bold"><?php echo e($product->name); ?></span>
                                    </div>
                                </td>
                                <td><?php echo e(number_format($product->price)); ?> ج.م</td>
                                <td>
                                    <?php if($product->stock > 0): ?>
                                        <span class="badge badge-success gap-1"><?php echo e($product->stock); ?> متوفر</span>
                                    <?php else: ?>
                                        <span class="badge badge-error gap-1">نفذ</span>
                                    <?php endif; ?>
                                </td>
                                <td><?php echo e($product->created_at->format('Y-m-d')); ?></td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="4" class="text-center py-8 text-gray-400">لا توجد منتجات مرتبطة بهذا القسم حالياً.</td>
                            </tr>
                        <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal23a33f287873b564aaf305a1526eada4)): ?>
<?php $attributes = $__attributesOriginal23a33f287873b564aaf305a1526eada4; ?>
<?php unset($__attributesOriginal23a33f287873b564aaf305a1526eada4); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal23a33f287873b564aaf305a1526eada4)): ?>
<?php $component = $__componentOriginal23a33f287873b564aaf305a1526eada4; ?>
<?php unset($__componentOriginal23a33f287873b564aaf305a1526eada4); ?>
<?php endif; ?>
<?php /**PATH C:\Users\USER\Herd\electric-store-api\resources\views/admin/categories/show.blade.php ENDPATH**/ ?>