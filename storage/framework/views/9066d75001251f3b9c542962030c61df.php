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

    
   <?php if (isset($component)) { $__componentOriginal4d4b92557ee68577852f631c644b53ff = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal4d4b92557ee68577852f631c644b53ff = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.welcome.ticker','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('welcome.ticker'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal4d4b92557ee68577852f631c644b53ff)): ?>
<?php $attributes = $__attributesOriginal4d4b92557ee68577852f631c644b53ff; ?>
<?php unset($__attributesOriginal4d4b92557ee68577852f631c644b53ff); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal4d4b92557ee68577852f631c644b53ff)): ?>
<?php $component = $__componentOriginal4d4b92557ee68577852f631c644b53ff; ?>
<?php unset($__componentOriginal4d4b92557ee68577852f631c644b53ff); ?>
<?php endif; ?>
    
    <div class="bg-base-100 border-b border-base-300 sticky top-0 z-30 shadow-sm">
        <div class="container mx-auto px-4 pt-4 pb-3">

            
            <div class="flex items-center gap-4">

                
                <label for="filter-drawer" class="btn btn-ghost btn-sm btn-square lg:hidden flex-shrink-0">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2a1 1 0 01-.293.707L13 13.414V19a1 1 0 01-.553.894l-4 2A1 1 0 017 21v-7.586L3.293 6.707A1 1 0 013 6V4z"/>
                    </svg>
                </label>

                
                <div class="flex-shrink-0">
                    <p class="text-[10px] font-black tracking-widest uppercase text-warning leading-none mb-0.5 hidden sm:block">متجرنا الإلكتروني</p>
                    <h1 class="text-lg sm:text-2xl font-black text-base-content leading-tight">المنتجات الكهربائية</h1>
                    <p class="text-[10px] text-base-content/40 mt-0.5"><?php echo e($products->total()); ?> منتج متاح</p>
                </div>

                
                <div class="hidden sm:block w-px h-10 bg-base-300 flex-shrink-0"></div>

                
                <form method="GET" action="<?php echo e(route('products.index')); ?>"
                      class="flex items-center gap-2 flex-1">
                    <?php if(request('category')): ?>
                        <input type="hidden" name="category" value="<?php echo e(request('category')); ?>">
                    <?php endif; ?>
                    <?php if(request('sort')): ?>
                        <input type="hidden" name="sort" value="<?php echo e(request('sort')); ?>">
                    <?php endif; ?>
                    <label class="input input-bordered flex items-center gap-2 flex-1 h-10">
                        <svg class="w-4 h-4 opacity-40 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <circle cx="11" cy="11" r="8"/><path stroke-linecap="round" d="M21 21l-4.35-4.35"/>
                        </svg>
                        <input type="text" name="search" value="<?php echo e(request('search')); ?>"
                               placeholder="ابحث باسم المنتج أو الماركة..." class="grow min-w-0 text-sm">
                        <?php if(request('search')): ?>
                            <a href="<?php echo e(route('products.index', request()->except('search'))); ?>"
                               class="opacity-40 hover:opacity-100 transition-opacity flex-shrink-0">✕</a>
                        <?php endif; ?>
                    </label>
                    <button type="submit" class="btn btn-warning font-black h-10 min-h-0 px-5 flex-shrink-0">بحث</button>
                </form>
            </div>

            
            <div class="flex items-center gap-2 mt-3 overflow-x-auto pb-0.5"
                 style="-webkit-overflow-scrolling:touch;scrollbar-width:none;">
                <style>div::-webkit-scrollbar{display:none}</style>
                <span class="text-[11px] font-bold text-base-content/40 flex-shrink-0 ml-1">تصفية:</span>

                <a href="<?php echo e(route('products.index', request()->except('category'))); ?>"
                   class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold
                          transition-all duration-200 flex-shrink-0 whitespace-nowrap border
                          <?php echo e(!request('category')
                             ? 'bg-warning text-warning-content border-warning'
                             : 'bg-base-200 border-base-300 text-base-content/60 hover:border-warning hover:text-warning'); ?>">
                    الكل
                    <span class="text-[10px] opacity-70"><?php echo e($categories->sum('products_count')); ?></span>
                </a>

                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <a href="<?php echo e(route('products.index', array_merge(request()->all(), ['category' => $cat->id]))); ?>"
                       class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold
                              transition-all duration-200 flex-shrink-0 whitespace-nowrap border
                              <?php echo e(request('category') == $cat->id
                                 ? 'bg-warning text-warning-content border-warning'
                                 : 'bg-base-200 border-base-300 text-base-content/60 hover:border-warning hover:text-warning'); ?>">
                        <?php echo e($cat->icon ?? ''); ?> <?php echo e($cat->name); ?>

                        <span class="text-[10px] opacity-70"><?php echo e($cat->products_count); ?></span>
                    </a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </div>

    
    <div class="drawer lg:drawer-open">
        <input id="filter-drawer" type="checkbox" class="drawer-toggle">

        
        <div class="drawer-content">
            <div class="container mx-auto px-4 py-6">

                
                <div class="flex flex-wrap items-center justify-between gap-3 mb-6
                             pb-4 border-b border-base-300">
                    
                    <div class="flex items-center gap-2 flex-wrap">
                        <?php if($activeCategory): ?>
                            <div class="badge badge-warning gap-1 font-bold py-2.5 px-3">
                                <?php echo e($activeCategory->icon ?? '⚡'); ?> <?php echo e($activeCategory->name); ?>

                                <a href="<?php echo e(route('products.index', request()->except('category'))); ?>"
                                   class="hover:opacity-60 font-black">✕</a>
                            </div>
                        <?php endif; ?>
                        <?php if(request('search')): ?>
                            <div class="badge badge-info gap-1 font-bold py-2.5 px-3">
                                🔍 "<?php echo e(request('search')); ?>"
                                <a href="<?php echo e(route('products.index', request()->except('search'))); ?>"
                                   class="hover:opacity-60">✕</a>
                            </div>
                        <?php endif; ?>
                        <?php if($activeBrand): ?>
                            <div class="badge badge-secondary gap-1 font-bold py-2.5 px-3">
                                🏷️ <?php echo e($activeBrand->name); ?>

                                <a href="<?php echo e(route('products.index', request()->except('brand'))); ?>"
                                   class="hover:opacity-60">✕</a>
                            </div>
                        <?php endif; ?>
                        <span class="text-xs text-base-content/40 font-semibold">
                            <?php echo e($products->total()); ?> نتيجة
                        </span>
                    </div>

                    
                    <form method="GET" action="<?php echo e(route('products.index')); ?>">
                        <?php $__currentLoopData = request()->except('sort'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <input type="hidden" name="<?php echo e($k); ?>" value="<?php echo e($v); ?>">
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <select name="sort" onchange="this.form.submit()"
                                class="select select-bordered select-sm text-xs font-bold w-40 sm:w-44">
                            <option value="">الأحدث</option>
                            <option value="price_asc"  <?php echo e(request('sort') === 'price_asc'  ? 'selected' : ''); ?>>السعر: الأقل أولاً</option>
                            <option value="price_desc" <?php echo e(request('sort') === 'price_desc' ? 'selected' : ''); ?>>السعر: الأعلى أولاً</option>
                            <option value="name_asc"   <?php echo e(request('sort') === 'name_asc'   ? 'selected' : ''); ?>>الاسم: أ → ي</option>
                        </select>
                    </form>
                </div>

                
                <?php if($products->isEmpty()): ?>
                <div class="flex flex-col items-center justify-center py-24 gap-4 text-center">
                    <div class="w-20 h-20 rounded-2xl bg-base-100 border border-base-300 flex items-center justify-center">
                        <svg class="w-8 h-8 text-base-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.2">
                            <path stroke-linecap="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                        </svg>
                    </div>
                    <p class="text-base font-black">لا توجد منتجات</p>
                    <p class="text-sm text-base-content/50">جرب تغيير كلمة البحث أو الفلتر</p>
                    <a href="<?php echo e(route('products.index')); ?>" class="btn btn-warning btn-sm font-black">عرض كل المنتجات</a>
                </div>

                <?php else: ?>


                    
                    
                    <div class="grid grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-4 sm:gap-6 p-4">
                        <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                                $stock = $product->stock;

                                $finalPriceValue     = $product->final_price;
                                $finalPriceFormatted = number_format($finalPriceValue, 2);
                                $origPriceFormatted  = number_format($product->price, 2);

                                $currentDiscount = $product->effective_discount;
                                $hasDisc         = $currentDiscount > 0;
                            ?>

                            
                            <div class="card bg-[#111317] border border-white/5 shadow-xl flex flex-col p-3.5 sm:p-4
                    hover:-translate-y-1.5 hover:border-warning/40 hover:shadow-[0_0_25px_rgba(252,163,17,0.08)]
                    transition-all duration-500 group overflow-hidden rounded-2xl relative">

                                
                                <a href="<?php echo e(route('products.show', $product->id)); ?>"
                                   class="absolute inset-0 z-0 after:absolute after:inset-0"
                                   aria-label="<?php echo e($product->name); ?>">
                                </a>

                                
                                <a href="<?php echo e(route('products.show', $product->id)); ?>" class="relative z-20 block overflow-hidden rounded-xl">
                                    <figure class="relative overflow-hidden bg-white flex-shrink-0 h-40 sm:h-48 p-3 border border-white/5 transition-transform duration-700 ease-out group-hover:scale-105">

                                        <?php if (isset($component)) { $__componentOriginala58dde406db9207f2e2c58e1c4a3d690 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala58dde406db9207f2e2c58e1c4a3d690 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.product-image','data' => ['product' => $product,'lazy' => $loop->index >= 4,'class' => 'w-full h-full object-contain']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('product-image'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['product' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($product),'lazy' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($loop->index >= 4),'class' => 'w-full h-full object-contain']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginala58dde406db9207f2e2c58e1c4a3d690)): ?>
<?php $attributes = $__attributesOriginala58dde406db9207f2e2c58e1c4a3d690; ?>
<?php unset($__attributesOriginala58dde406db9207f2e2c58e1c4a3d690); ?>
<?php endif; ?>
<?php if (isset($__componentOriginala58dde406db9207f2e2c58e1c4a3d690)): ?>
<?php $component = $__componentOriginala58dde406db9207f2e2c58e1c4a3d690; ?>
<?php unset($__componentOriginala58dde406db9207f2e2c58e1c4a3d690); ?>
<?php endif; ?>

                                        
                                        <?php if($hasDisc): ?>
                                            <span class="absolute top-2 right-2 z-30 bg-[#f87171] text-white text-[10px] font-black px-2 py-0.5 rounded-md shadow-sm">
                         -%<?php echo e($currentDiscount); ?>

                        </span>
                                        <?php endif; ?>

                                        <span class="absolute top-2 left-2 z-30 text-[9px] font-bold px-2 py-0.5 rounded-md shadow-sm backdrop-blur-md flex items-center gap-1 border
                                 <?php echo e($stock > 10 ? 'bg-[#10b981]/10 border-[#10b981]/30 text-[#10b981]' : ($stock > 0 ? 'bg-[#fbbf24]/10 border-[#fbbf24]/30 text-[#fbbf24]' : 'bg-[#ef4444]/10 border-[#ef4444]/30 text-[#ef4444]')); ?>">
                        <span class="w-1.5 h-1.5 rounded-full <?php echo e($stock > 10 ? 'bg-[#10b981]' : ($stock > 0 ? 'bg-[#fbbf24] animate-pulse' : 'bg-[#ef4444]')); ?>"></span>
                        <?php echo e($stock > 10 ? 'متوفر' : ($stock > 0 ? 'محدود' : 'نفذ')); ?>

                    </span>

                                        <?php if($product->category): ?>
                                            <span class="absolute bottom-2 right-2 hidden sm:inline-block z-30 bg-[#1a1d24]/90 backdrop-blur-sm text-[9px] font-bold text-white/70 px-2 py-0.5 rounded border border-white/5">
                            <?php echo e($product->category->name); ?>

                        </span>
                                        <?php endif; ?>
                                    </figure>
                                </a>

                                
                                <div class="flex flex-col flex-1 gap-2.5 mt-3 relative z-10">

                                    
                                    <h3 class="font-bold text-xs sm:text-sm text-white/90 leading-snug line-clamp-2 min-h-[2.6em] group-hover:text-warning transition-colors duration-300">
                                        <?php echo e($product->name); ?>

                                    </h3>

                                    
                                    <div class="flex items-end justify-between mt-auto pt-2 border-t border-white/5">
                                        <div>
                                            <p class="text-base sm:text-lg font-black text-warning leading-none flex items-baseline gap-0.5">
                                                <?php echo e($finalPriceFormatted); ?> <span class="text-[10px] font-normal text-white/40">ج.م</span>
                                            </p>
                                            <?php if($hasDisc): ?>
                                                <p class="text-[10px] line-through text-white/20 mt-0.5"><?php echo e($origPriceFormatted); ?> ج.م</p>
                                            <?php endif; ?>
                                        </div>
                                    </div>

                                    
                                    <div class="flex items-center gap-2 mt-1 relative z-20">

                                        
                                        <form action="<?php echo e(route('cart.add', $product->id)); ?>" method="POST" class="flex-1 flex m-0 p-0">
                                            <?php echo csrf_field(); ?>
                                            <input type="hidden" name="name"     value="<?php echo e($product->name); ?>">
                                            <input type="hidden" name="price"    value="<?php echo e($finalPriceValue); ?>">
                                            <input type="hidden" name="image"    value="<?php echo e($product->image_url); ?>">
                                            <input type="hidden" name="quantity" value="1">

                                            <button type="submit"
                                                    class="btn btn-sm h-9 min-h-0 flex-1 gap-1.5 font-bold text-xs rounded-xl border-none shadow-md transition-all duration-300
                                       <?php echo e($stock > 0 ? 'bg-warning text-black hover:bg-warning/80 shadow-warning/5' : 'bg-white/5 text-white/30 btn-disabled opacity-40'); ?>"
                                                <?php echo e($stock <= 0 ? 'disabled' : ''); ?>>
                                                <svg class="w-3.5 h-3.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                                    <path stroke-linecap="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                                                </svg>
                                                <span><?php echo e($stock <= 0 ? 'نفذ' : 'أضف للسلة'); ?></span>
                                            </button>
                                        </form>

                                        
                                        <?php if (isset($component)) { $__componentOriginal64632d3764858f5ee3301d7f8e271eff = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal64632d3764858f5ee3301d7f8e271eff = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.wishlist-button','data' => ['product' => $product]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('wishlist-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['product' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($product)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal64632d3764858f5ee3301d7f8e271eff)): ?>
<?php $attributes = $__attributesOriginal64632d3764858f5ee3301d7f8e271eff; ?>
<?php unset($__attributesOriginal64632d3764858f5ee3301d7f8e271eff); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal64632d3764858f5ee3301d7f8e271eff)): ?>
<?php $component = $__componentOriginal64632d3764858f5ee3301d7f8e271eff; ?>
<?php unset($__componentOriginal64632d3764858f5ee3301d7f8e271eff); ?>
<?php endif; ?>

                                        
                                        <div class="tooltip tooltip-top hover:before:bg-warning hover:before:text-black" data-tip="عرض المنتج">
                                            <a href="<?php echo e(route('products.show', $product->id)); ?>"
                                               class="btn btn-sm btn-square h-9 w-9 bg-[#1a1d24] hover:bg-warning hover:text-black border border-white/5 rounded-xl transition-all duration-300 text-white/70 flex items-center justify-center">
                                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                                    <path stroke-linecap="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                    <path stroke-linecap="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                                </svg>
                                            </a>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>


                <?php if($products->hasPages()): ?>
                    <div class="flex justify-center mt-8 sm:mt-10">
                        <?php echo e($products->withQueryString()->links()); ?>

                    </div>
                <?php endif; ?>
                <?php endif; ?>

            </div>
        </div>

        
        <div class="drawer-side z-40">
            <label for="filter-drawer" aria-label="close sidebar" class="drawer-overlay"></label>

            <aside class="bg-base-100 w-56 min-h-full flex flex-col border-l border-base-300">

                
                <div class="flex items-center justify-between px-4 py-3 border-b border-base-300 flex-shrink-0">
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-warning" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2a1 1 0 01-.293.707L13 13.414V19a1 1 0 01-.553.894l-4 2A1 1 0 017 21v-7.586L3.293 6.707A1 1 0 013 6V4z"/>
                        </svg>
                        <span class="text-sm font-black">الفلاتر</span>
                    </div>
                    <label for="filter-drawer" class="btn btn-ghost btn-xs btn-square lg:hidden opacity-50 hover:opacity-100">✕</label>
                </div>

                <div class="flex flex-col flex-1 overflow-y-auto divide-y divide-base-200">

                    
                    <div class="py-2">
                        <p class="px-4 pt-1 pb-2 text-[10px] font-black tracking-[.15em] uppercase text-base-content/35">
                            الأقسام
                        </p>
                        <?php $noCat = !request('category'); ?>
                        <a href="<?php echo e(route('products.index', request()->except('category'))); ?>"
                           class="group flex items-center gap-2.5 px-3 py-1.5 mx-1 rounded-lg text-xs transition-all duration-150
                                  <?php echo e($noCat ? 'bg-warning/15 text-warning font-bold' : 'text-base-content/55 hover:bg-base-200 hover:text-base-content'); ?>">
                            <span class="w-0.5 h-4 rounded-full transition-all <?php echo e($noCat ? 'bg-warning' : 'bg-transparent group-hover:bg-base-300'); ?>"></span>
                            <span class="text-sm">📦</span>
                            <span class="flex-1 truncate">جميع المنتجات</span>
                            <span class="text-[10px] font-bold min-w-[18px] text-center px-1 py-0.5 rounded
                                         <?php echo e($noCat ? 'bg-warning/25 text-warning' : 'bg-base-200 text-base-content/40'); ?>">
                                <?php echo e($categories->sum('products_count')); ?>

                            </span>
                        </a>
                        <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php $cAct = request('category') == $cat->id; ?>
                            <a href="<?php echo e(route('products.index', array_merge(request()->all(), ['category' => $cat->id]))); ?>"
                               class="group flex items-center gap-2.5 px-3 py-1.5 mx-1 rounded-lg text-xs transition-all duration-150
                                      <?php echo e($cAct ? 'bg-warning/15 text-warning font-bold' : 'text-base-content/55 hover:bg-base-200 hover:text-base-content'); ?>">
                                <span class="w-0.5 h-4 rounded-full transition-all <?php echo e($cAct ? 'bg-warning' : 'bg-transparent group-hover:bg-base-300'); ?>"></span>
                                <span class="text-sm"><?php echo e($cat->icon ?? '⚡'); ?></span>
                                <span class="flex-1 truncate"><?php echo e($cat->name); ?></span>
                                <span class="text-[10px] font-bold min-w-[18px] text-center px-1 py-0.5 rounded
                                             <?php echo e($cAct ? 'bg-warning/25 text-warning' : 'bg-base-200 text-base-content/40'); ?>">
                                    <?php echo e($cat->products_count); ?>

                                </span>
                            </a>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>

                    
                    <?php if($brands->count() > 0): ?>
                    <div class="py-2" x-data="brandFilter()" x-init="init()">

                        
                        <button type="button"
                                @click="open = !open"
                                class="w-full flex items-center gap-1.5 px-4 pt-1 pb-2 group">
                            <span class="text-[10px] font-black tracking-[.15em] uppercase text-base-content/35 flex-1 text-right">
                                الماركات
                            </span>
                            <?php if(request('brand')): ?>
                                <span class="w-1.5 h-1.5 rounded-full bg-warning flex-shrink-0"></span>
                            <?php endif; ?>
                            <svg class="w-3 h-3 text-base-content/30 transition-transform duration-200 flex-shrink-0"
                                 :class="open ? 'rotate-180' : ''"
                                 fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>

                        <div x-show="open" x-collapse>

                            
                            <div class="px-3 pb-2">
                                <div class="flex items-center gap-1.5 px-2.5 py-1.5 rounded-lg bg-base-200 border border-base-300">
                                    <svg class="w-3 h-3 text-base-content/30 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <circle cx="11" cy="11" r="8"/><path stroke-linecap="round" d="M21 21l-4.35-4.35"/>
                                    </svg>
                                    <input type="text"
                                           x-model="query"
                                           @input="filter()"
                                           placeholder="ابحث عن ماركة..."
                                           class="grow bg-transparent text-[11px] outline-none text-base-content placeholder:text-base-content/30">
                                    <button x-show="query" @click="query='';filter()"
                                            class="text-base-content/30 hover:text-base-content/60 text-xs leading-none">✕</button>
                                </div>
                            </div>

                            
                            <?php $noBrand = !request('brand'); ?>
                            <a href="<?php echo e(route('products.index', request()->except('brand'))); ?>"
                               class="group flex items-center gap-2.5 px-3 py-1.5 mx-1 rounded-lg text-xs transition-all duration-150
                                      <?php echo e($noBrand ? 'bg-warning/15 text-warning font-bold' : 'text-base-content/55 hover:bg-base-200 hover:text-base-content'); ?>">
                                <span class="w-0.5 h-4 rounded-full <?php echo e($noBrand ? 'bg-warning' : 'bg-transparent group-hover:bg-base-300'); ?>"></span>
                                <span class="flex-1">الكل</span>
                                <span class="text-[10px] font-bold min-w-[18px] text-center px-1 py-0.5 rounded
                                             <?php echo e($noBrand ? 'bg-warning/25 text-warning' : 'bg-base-200 text-base-content/40'); ?>">
                                    <?php echo e($brands->sum('products_count')); ?>

                                </span>
                            </a>

                            
                            <div id="brand-list" class="max-h-52 overflow-y-auto">
                                <?php $__currentLoopData = $brands; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $brand): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php $bAct = request('brand') == $brand->id; ?>
                                    <a href="<?php echo e(route('products.index', array_merge(request()->all(), ['brand' => $brand->id]))); ?>"
                                       data-brand="<?php echo e(mb_strtolower($brand->name)); ?>"
                                       class="brand-item group flex items-center gap-2.5 px-3 py-1.5 mx-1 rounded-lg text-xs transition-all duration-150
                                              <?php echo e($bAct ? 'bg-warning/15 text-warning font-bold' : 'text-base-content/55 hover:bg-base-200 hover:text-base-content'); ?>">
                                        <span class="w-0.5 h-4 rounded-full <?php echo e($bAct ? 'bg-warning' : 'bg-transparent group-hover:bg-base-300'); ?>"></span>
                                        <span class="flex-1 truncate"><?php echo e($brand->name); ?></span>
                                        <span class="text-[10px] font-bold min-w-[18px] text-center px-1 py-0.5 rounded
                                                     <?php echo e($bAct ? 'bg-warning/25 text-warning' : 'bg-base-200 text-base-content/40'); ?>">
                                            <?php echo e($brand->products_count); ?>

                                        </span>
                                    </a>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                
                                <p id="brand-empty"
                                   class="hidden text-center text-[11px] text-base-content/30 py-3 px-4">
                                    لا توجد نتائج
                                </p>
                            </div>

                        </div>
                    </div>
                    <?php endif; ?>

                    
                    <div class="py-2">
                        <p class="px-4 pt-1 pb-2 text-[10px] font-black tracking-[.15em] uppercase text-base-content/35">
                            المخزون
                        </p>
                        <?php $__currentLoopData = [
                            ['available', 'bg-success', 'bg-success/15',     'متوفر فقط'],
                            ['low',       'bg-warning', 'bg-warning/15',     'كمية محدودة'],
                        ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as [$val, $dotBg, $activeBg, $label]): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php $sAct = request('stock') === $val; ?>
                            <a href="<?php echo e(route('products.index', array_merge(request()->all(), ['stock' => $val]))); ?>"
                               class="group flex items-center gap-2.5 px-3 py-1.5 mx-1 rounded-lg text-xs transition-all duration-150
                                      <?php echo e($sAct ? $activeBg . ' font-bold' : 'text-base-content/55 hover:bg-base-200 hover:text-base-content'); ?>

                                      <?php echo e($sAct && $val === 'available' ? 'text-success' : ''); ?>

                                      <?php echo e($sAct && $val === 'low' ? 'text-warning' : ''); ?>

                                      <?php echo e($sAct && $val === 'all' ? 'text-base-content' : ''); ?>">
                                <span class="w-0.5 h-4 rounded-full <?php echo e($sAct ? ($val === 'available' ? 'bg-success' : ($val === 'low' ? 'bg-warning' : 'bg-base-content/40')) : 'bg-transparent group-hover:bg-base-300'); ?>"></span>
                                <span class="w-2 h-2 rounded-full flex-shrink-0
                                             <?php echo e($dotBg ?: 'bg-base-content/30'); ?>

                                             <?php echo e($val === 'available' && $sAct ? 'animate-pulse' : ''); ?>">
                                </span>
                                <span class="flex-1"><?php echo e($label); ?></span>
                            </a>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>

                </div>
            </aside>
        </div>
    </div>

</div>

<style>
    @keyframes ticker {
        from { transform: translateX(-50%); }
        to   { transform: translateX(0); }
    }
</style>


<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
<script>
function brandFilter() {
    return {
        open: <?php echo e(request('brand') ? 'true' : 'false'); ?>,
        query: '',
        init() {},
        filter() {
            const q = this.query.trim().toLowerCase();
            const items = document.querySelectorAll('.brand-item');
            const empty = document.getElementById('brand-empty');
            let visible = 0;
            items.forEach(el => {
                const name = el.dataset.brand || '';
                const show = !q || name.includes(q);
                el.style.display = show ? '' : 'none';
                if (show) visible++;
            });
            if (empty) empty.classList.toggle('hidden', visible > 0);
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
<?php /**PATH C:\Users\USER\Herd\electric-store-api\resources\views/products/index.blade.php ENDPATH**/ ?>