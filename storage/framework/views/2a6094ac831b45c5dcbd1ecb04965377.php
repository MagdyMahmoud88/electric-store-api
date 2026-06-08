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

    <div dir="rtl" class="min-h-screen bg-base-200">
        <div class="container mx-auto px-4 py-6 sm:py-10 max-w-5xl">

            
            <nav class="breadcrumbs text-sm mb-6 sm:mb-8">
                <ul>
                    <li><a href="<?php echo e(route('products.index')); ?>" class="text-base-content/50 hover:text-warning transition-colors">المنتجات</a></li>
                    <li class="text-base-content/80 font-semibold truncate max-w-[180px] sm:max-w-xs"><?php echo e($product->name); ?></li>
                </ul>
            </nav>

            
            <?php if(session('success')): ?>
                <div role="alert" class="alert alert-success mb-6">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span class="text-sm font-semibold"><?php echo e(session('success')); ?></span>
                </div>
            <?php endif; ?>

            
            <div class="card bg-base-100 border border-base-300 shadow-lg overflow-hidden">
                <div class="grid grid-cols-1 md:grid-cols-2">

                    
                    <div class="relative bg-base-200 overflow-hidden"
                         style="min-height: clamp(260px, 50vw, 480px);">
                        <img src="<?php echo e($product->getImageSrc()); ?>"
                             alt="<?php echo e($product->name); ?>"
                             class="w-full h-full object-contain bg-white transition-transform duration-700 hover:scale-105"
                             onerror="this.onerror=null;this.src='<?php echo e($product->getPlaceholder()); ?>'">

                        
                        <?php if($product->category): ?>
                            <div class="absolute top-4 right-4">
                                <div class="badge badge-ghost bg-base-300/80 backdrop-blur-sm border-0 font-bold px-3 py-3 text-xs">
                                    <?php echo e($product->category->name ?? $product->category); ?>

                                </div>
                            </div>
                        <?php endif; ?>

                        
                        <?php if($product->effective_discount > 0): ?>
                            <div class="absolute top-4 left-4">
                                <div class="badge badge-error font-black px-3 py-3 text-xs">
                                    خصم <?php echo e($product->effective_discount); ?>%
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>

                    
                    <div class="flex flex-col p-5 sm:p-8 gap-5">

                        
                        <div>
                            <p class="text-[10px] font-black tracking-widest uppercase text-warning mb-2">
                                <?php echo e($product->category->name ?? 'منتج'); ?>

                            </p>
                            <h1 class="text-xl sm:text-2xl lg:text-3xl font-black text-base-content leading-snug">
                                <?php echo e($product->name); ?>

                            </h1>
                        </div>

                        
                        <p class="text-sm text-base-content/60 leading-relaxed pb-5 border-b border-base-300">
                            <?php echo e($product->description); ?>

                        </p>

                        
                        <?php
                            $discount   = $product->effective_discount;
                          $finalPrice = $product->final_price;
                        ?>
                        <div class="flex items-end gap-3 flex-wrap">
                        <span class="text-3xl sm:text-4xl font-black text-warning leading-none">
                            <?php echo e(number_format($finalPrice, 2)); ?>

                            <span class="text-sm font-normal text-base-content/50">ج.م</span>
                        </span>
                            <?php if($discount > 0): ?>
                                <div class="flex items-center gap-2 mb-1">
                                    <span class="badge badge-error badge-sm font-bold">خصم <?php echo e($discount); ?>%</span>

                                    <span class="text-sm line-through text-base-content/40">
                                    <?php echo e(number_format($product->price, 2)); ?> ج.م
                                </span>
                                </div>
                            <?php endif; ?>
                        </div>

                        
                        <?php $stock = $product->stock; ?>
                        <div class="flex items-center gap-3 flex-wrap">
                            <?php if($stock > 10): ?>
                                <div class="badge badge-success gap-2 py-3 px-3 font-bold">
                                    <span class="w-2 h-2 rounded-full bg-success-content/70 animate-pulse"></span>
                                    متوفر
                                </div>
                                <span class="text-xs text-base-content/50"><?php echo e($stock); ?> وحدة متاحة</span>
                            <?php elseif($stock > 0): ?>
                                <div class="badge badge-warning gap-2 py-3 px-3 font-bold animate-pulse">
                                    <span class="w-2 h-2 rounded-full bg-warning-content/70"></span>
                                    كمية محدودة
                                </div>
                                <span class="text-xs text-warning font-black">متبقي <?php echo e($stock); ?> فقط!</span>
                            <?php else: ?>
                                <div class="badge badge-error gap-2 py-3 px-3 font-bold">
                                    <span class="w-2 h-2 rounded-full bg-error-content/70"></span>
                                    نفذ المخزون
                                </div>
                            <?php endif; ?>
                        </div>

                        
                        <?php if($stock > 0): ?>
                            <div>
                                <p class="text-xs font-bold text-base-content/50 mb-2">الكمية</p>
                                <div class="flex items-center gap-0 w-fit
                                    rounded-xl overflow-hidden border border-base-300 bg-base-200">
                                    <button type="button" onclick="changeQty(-1)"
                                            class="btn btn-ghost btn-sm w-10 h-10 rounded-none text-lg font-black p-0
                                           hover:bg-base-300 border-l border-base-300 transition-colors">−</button>
                                    <input type="number" name="quantity" id="qty"
                                           value="1" min="1" max="<?php echo e($stock); ?>" readonly
                                           class="w-14 h-10 text-center bg-transparent font-black text-base
                                          text-base-content border-none outline-none">
                                    <button type="button" onclick="changeQty(1)"
                                            class="btn btn-ghost btn-sm w-10 h-10 rounded-none text-lg font-black p-0
                                           hover:bg-base-300 border-r border-base-300 transition-colors">+</button>
                                </div>
                            </div>
                        <?php endif; ?>

                        
                        <div class="mt-auto flex flex-col gap-3">
                            <div class="flex flex-col sm:flex-row gap-3">

                                
                                <form action="<?php echo e(route('cart.add', $product->id)); ?>" method="POST" class="flex-1">
                                    <?php echo csrf_field(); ?>
                                    <input type="hidden" name="name"  value="<?php echo e($product->name); ?>">
                                    <input type="hidden" name="price" value="<?php echo e(number_format($finalPrice, 2)); ?>">
                                    <input type="hidden" name="image" value="<?php echo e($product->image_url ?? $product->image); ?>">
                                    <input type="hidden" name="quantity" class="hidden-qty-connector" value="1">

                                    <button type="submit"
                                            class="btn btn-warning w-full gap-2 font-black text-sm <?php echo e($stock <= 0 ? 'btn-disabled' : ''); ?>"
                                        <?php echo e($stock <= 0 ? 'disabled' : ''); ?>>
                                        <svg class="w-4 h-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                                        </svg>
                                        إضافة للسلة
                                    </button>
                                </form>

                                
                                <?php if($stock > 0): ?>
                                    <form action="<?php echo e(route('checkout.fast-buy', $product->id)); ?>" method="POST" class="flex-1">
                                        <?php echo csrf_field(); ?>
                                        <input type="hidden" name="quantity" id="fast-buy-qty" value="1">

                                        <button type="submit"
                                                class="btn btn-primary w-full gap-2 font-black text-sm">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                            </svg>
                                            أشترى الآن
                                        </button>
                                    </form>
                                <?php endif; ?>

                                
                                <a href="<?php echo e(route('products.index')); ?>"
                                   class="btn btn-ghost border border-base-300 hover:border-warning hover:text-warning font-bold text-sm gap-2 flex-shrink-0">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                                    </svg>
                                    <span class="hidden sm:inline">العودة</span>
                                </a>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            
            <?php if($product->brand ?? false): ?>
                <div class="mt-4 flex flex-wrap gap-3">
                    <div class="badge badge-ghost badge-lg gap-2 py-3 font-semibold text-xs">
                        🏷️ الماركة:
                        <span class="font-black"><?php echo e($product->brand->name ?? $product->brand); ?></span>
                    </div>
                </div>
            <?php endif; ?>

            
            <div class="card bg-base-100 border border-base-300 shadow-sm mt-6 p-5 sm:p-8">
                <?php if (isset($component)) { $__componentOriginal320073c5f7711d8c88da1a05242f26fd = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal320073c5f7711d8c88da1a05242f26fd = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.product-reviews','data' => ['product' => $product]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('product-reviews'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['product' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($product)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal320073c5f7711d8c88da1a05242f26fd)): ?>
<?php $attributes = $__attributesOriginal320073c5f7711d8c88da1a05242f26fd; ?>
<?php unset($__attributesOriginal320073c5f7711d8c88da1a05242f26fd); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal320073c5f7711d8c88da1a05242f26fd)): ?>
<?php $component = $__componentOriginal320073c5f7711d8c88da1a05242f26fd; ?>
<?php unset($__componentOriginal320073c5f7711d8c88da1a05242f26fd); ?>
<?php endif; ?>
            </div>

        </div>
    </div>

    <script>
        // دالة تغيير الكمية وتحديث قيم المدخلات المخفية لنموذجي السلة والشراء السريع
        function changeQty(delta) {
            const input = document.getElementById('qty');
            if (!input) return;

            const max = parseInt(input.max) || 999;
            let val = parseInt(input.value) + delta;

            if (val >= 1 && val <= max) {
                input.value = val;

                // ربط القيمة الجديدة بحقل الشراء السريع المخفي
                const fastBuyInput = document.getElementById('fast-buy-qty');
                if (fastBuyInput) {
                    fastBuyInput.value = val;
                }

                // ربط القيمة الجديدة بحقل السلة المخفي أيضاً
                const cartInput = document.querySelector('.hidden-qty-connector');
                if (cartInput) {
                    cartInput.value = val;
                }
            }
        }
    </script>

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
<?php /**PATH C:\Users\USER\Herd\electric-store-api\resources\views/products/show.blade.php ENDPATH**/ ?>