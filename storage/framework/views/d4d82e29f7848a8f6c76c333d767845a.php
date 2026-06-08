<?php if(auth()->guard()->check()): ?>
    <?php
        $inWishlist = auth()->user()->hasInWishlist($product->id);
    ?>

    
    <div class="relative group/tip">
        <button
            class="wishlist-btn btn btn-sm btn-square h-9 w-9 bg-[#1a1d24] text-white/70
                   hover:bg-warning hover:text-black border border-white/5 rounded-xl
                   transition-all duration-300 <?php echo e($inWishlist ? 'active' : ''); ?>"
            data-product-id="<?php echo e($product->id); ?>"
            data-toggle-url="<?php echo e(route('wishlist.toggle', $product->id)); ?>">
            <i class="fa-<?php echo e($inWishlist ? 'solid' : 'regular'); ?> fa-bookmark
                      <?php echo e($inWishlist ? 'text-error' : ''); ?>"></i>
        </button>

        
        <span class="tooltip-label pointer-events-none absolute bottom-full right-1/2 translate-x-1/2 mb-2
                     whitespace-nowrap rounded-md text-[10px] font-bold px-2 py-1
                     opacity-0 group-hover/tip:opacity-100 transition-opacity duration-200 z-50
                     <?php echo e($inWishlist ? 'bg-error text-white' : 'bg-warning text-black'); ?>">
            <?php echo e($inWishlist ? 'إزالة من المفضلة' : 'أضف للمفضلة'); ?>

        </span>
    </div>

<?php else: ?>
    
    <div class="relative group/tip">
        <a href="<?php echo e(route('login')); ?>"
           class="wishlist-btn btn btn-sm btn-square h-9 w-9 bg-[#1a1d24] text-white/70
                  hover:bg-warning hover:text-black border border-white/5 rounded-xl
                  transition-all duration-300 flex items-center justify-center">
            <i class="fa-regular fa-bookmark"></i>
        </a>

        
        <span class="pointer-events-none absolute bottom-full right-1/2 translate-x-1/2 mb-2
                     whitespace-nowrap rounded-md bg-warning text-black text-[10px] font-bold
                     px-2 py-1 opacity-0 group-hover/tip:opacity-100 transition-opacity duration-200 z-50">
            سجل دخول لإضافة للمفضلة
        </span>
    </div>

<?php endif; ?>


<?php if (! $__env->hasRenderedOnce('a015f4a7-7f9f-4c3d-8fba-88a587495fec')): $__env->markAsRenderedOnce('a015f4a7-7f9f-4c3d-8fba-88a587495fec'); ?>
    <?php $__env->startPush('scripts'); ?>
        <script>
            document.addEventListener('click', function (e) {
                const btn = e.target.closest('.wishlist-btn');
                if (!btn || btn.tagName === 'A') return;

                const url  = btn.dataset.toggleUrl;
                const icon = btn.querySelector('i');
                const wrapper = btn.closest('.relative');
                const label  = wrapper ? wrapper.querySelector('.tooltip-label') : null;

                btn.disabled = true;

                fetch(url, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept':       'application/json',
                        'Content-Type': 'application/json',
                    },
                })
                    .then(r => r.json())
                    .then(data => {
                        if (data.in_wishlist) {
                            icon.classList.replace('fa-regular', 'fa-solid');
                            icon.classList.add('text-error');
                            btn.classList.add('active');

                            if (label) {
                                label.textContent = 'إزالة من المفضلة';
                                label.classList.remove('bg-warning', 'text-black');
                                label.classList.add('bg-error', 'text-white');
                            }
                        } else {
                            icon.classList.replace('fa-solid', 'fa-regular');
                            icon.classList.remove('text-error');
                            btn.classList.remove('active');

                            if (label) {
                                label.textContent = 'أضف للمفضلة';
                                label.classList.remove('bg-error', 'text-white');
                                label.classList.add('bg-warning', 'text-black');
                            }
                        }

                        const counter = document.getElementById('wishlist-count');
                        if (counter) {
                            counter.textContent = data.count;
                            counter.style.display = data.count > 0 ? 'flex' : 'none';
                        }
                    })
                    .catch(() => alert('حصل خطأ، حاول تاني'))
                    .finally(() => btn.disabled = false);
            });
        </script>
    <?php $__env->stopPush(); ?>
<?php endif; ?>
<?php /**PATH C:\Users\USER\Herd\electric-store-api\resources\views/components/wishlist-button.blade.php ENDPATH**/ ?>