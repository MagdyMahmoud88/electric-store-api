<?php if (isset($component)) { $__componentOriginal23a33f287873b564aaf305a1526eada4 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal23a33f287873b564aaf305a1526eada4 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layout','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
     <?php $__env->slot('title', null, []); ?> المفضلة <?php $__env->endSlot(); ?>

    
    <section class="bg-base-200 border-b border-base-300 py-8">
        <div class="container mx-auto px-4">
            <div class="flex items-center justify-between flex-wrap gap-3">
                <div>
                    <h1 class="text-2xl font-bold" style="font-family: 'Cairo', sans-serif;">
                        <i class="fa-solid fa-heart text-error me-2"></i>
                        قائمة المفضلة
                        <?php if($items->isNotEmpty()): ?>
                            <span class="badge badge-error badge-sm ms-2 w-8 align-middle">
                                <?php echo e($items->count()); ?>

                            </span>
                        <?php endif; ?>
                    </h1>
                    <p class="text-base-content/60 text-sm mt-1">
                        المنتجات التي أضفتها للمفضلة
                    </p>
                </div>

                <?php if($items->isNotEmpty()): ?>
                    <form action="<?php echo e(route('wishlist.clear')); ?>" method="POST"
                          onsubmit="return confirm('هتمسح كل المفضلة؟')">
                        <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                        <button type="submit" class="btn btn-outline btn-error btn-sm gap-2">
                            <i class="fa-solid fa-trash-can fa-sm"></i>
                            مسح الكل
                        </button>
                    </form>
                <?php endif; ?>
            </div>
        </div>
    </section>

    
    <section class="container mx-auto px-4 py-10">

        <?php if($items->isEmpty()): ?>
            
            <div class="flex flex-col items-center justify-center py-24 gap-5 text-center">
                <div class="w-24 h-24 rounded-full bg-base-200 flex items-center justify-center">
                    <i class="fa-regular fa-heart text-4xl text-base-content/30"></i>
                </div>
                <div>
                    <h2 class="text-xl font-bold mb-1" style="font-family:'Cairo',sans-serif;">
                        المفضلة فارغة
                    </h2>
                    <p class="text-base-content/50 text-sm">
                        لم تضف أي منتجات للمفضلة بعد
                    </p>
                </div>
                <a href="<?php echo e(route('products.index')); ?>" class="btn btn-primary gap-2">
                    <i class="fa-solid fa-bag-shopping fa-sm"></i>
                    تصفح المنتجات
                </a>
            </div>

        <?php else: ?>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php $product = $item->product; ?>

                    <div class="card bg-base-100 border border-base-300
                                hover:border-primary hover:shadow-lg
                                transition-all duration-200 group"
                         id="wl-card-<?php echo e($product->id); ?>">

                        
                        <figure class="relative overflow-hidden h-52">
                            <a href="<?php echo e(route('products.show', $product->id)); ?>" class="block w-full h-full">
                                <img src="<?php echo e($product->image_url ?? asset('images/placeholder.png')); ?>"
                                     alt="<?php echo e($product->name); ?>"
                                     class="w-full h-full object-contain bg-white group-hover:scale-105 transition-transform duration-300"
                                     loading="lazy">
                            </a>

                            
                            <form action="<?php echo e(route('wishlist.remove', $product->id)); ?>"
                                  method="POST"
                                  class="absolute top-3 start-3">
                                <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                <button type="submit"
                                        title="إزالة من المفضلة"
                                        class="btn btn-circle btn-sm bg-base-100/90 border-0
                                               hover:bg-error hover:text-white transition-colors">
                                    <i class="fa-solid fa-trash fa-sm"></i>
                                </button>
                            </form>

                            
                            <?php if($product->brand): ?>
                                <span class="badge badge-ghost badge-sm
                                             absolute bottom-2 end-2
                                             bg-base-100/80 backdrop-blur-sm">
                                    <?php echo e($product->brand->name); ?>

                                </span>
                            <?php endif; ?>
                        </figure>

                        <div class="card-body p-4 gap-3">

                            
                            <a href="<?php echo e(route('products.show', $product->id)); ?>"
                               class="card-title text-sm font-bold leading-snug
                                      hover:text-primary transition-colors line-clamp-2"
                               style="font-family:'Cairo',sans-serif;">
                                <?php echo e($product->name); ?>

                            </a>

                            
                            <div class="flex items-center gap-2 flex-wrap">
                                <span class="text-primary font-bold text-lg">
                                    <?php echo e(number_format($product->price, 2)); ?>

                                </span>
                                <span class="text-base-content/50 text-xs">ج.م</span>

                                <?php if(isset($product->old_price) && $product->old_price > $product->price): ?>
                                    <span class="text-base-content/40 line-through text-xs">
                                        <?php echo e(number_format($product->old_price, 2)); ?>

                                    </span>
                                    <span class="badge badge-error badge-xs">
                                        خصم <?php echo e(round((1 - $product->price / $product->old_price) * 100)); ?>%
                                    </span>
                                <?php endif; ?>
                            </div>

                            
                            <?php $outOfStock = isset($product->stock) && $product->stock == 0; ?>

                            <?php if(isset($product->stock)): ?>
                                <?php if($product->stock > 0): ?>
                                    <span class="text-success text-xs flex items-center gap-1">
                                        <i class="fa-solid fa-circle-check fa-xs"></i>
                                        متوفر في المخزن
                                    </span>
                                <?php else: ?>
                                    <span class="text-error text-xs flex items-center gap-1">
                                        <i class="fa-solid fa-circle-xmark fa-xs"></i>
                                        نفد من المخزن
                                    </span>
                                <?php endif; ?>
                            <?php endif; ?>

                            
                            <div class="card-actions mt-auto">
                                <?php if($outOfStock): ?>
                                    <button class="btn btn-sm w-full gap-2 btn-disabled" disabled>
                                        <i class="fa-solid fa-cart-plus fa-sm"></i>
                                        نفد من المخزن
                                    </button>
                                <?php else: ?>
                                    <form action="<?php echo e(route('cart.add', $product->id)); ?>"
                                          method="POST"
                                          style="width:100%">
                                        <?php echo csrf_field(); ?>
                                        <input type="hidden" name="quantity" value="1">
                                        <button type="submit" class="btn btn-primary btn-sm w-full gap-2">
                                            <i class="fa-solid fa-cart-plus fa-sm"></i>
                                            أضف للسلة
                                        </button>
                                    </form>
                                <?php endif; ?>
                            </div>

                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>

            <p class="text-center text-base-content/40 text-sm mt-10">
                إجمالي <?php echo e($items->count()); ?> منتج في المفضلة
            </p>
        <?php endif; ?>

    </section>
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
<?php /**PATH C:\Users\USER\Herd\electric-store-api\resources\views/wishlist/index.blade.php ENDPATH**/ ?>