

<?php
    $reviews     = $product->approvedReviews()->with('user')->latest()->get();
    $avgRating   = $product->average_rating;
    $totalCount  = $product->ratings_count;
    $userReview  = auth()->check() ? $product->reviews()->where('user_id', auth()->id())->first() : null;
    $canReview   = auth()->check() && !$userReview;

    $distribution = [];
    for ($i = 5; $i >= 1; $i--) {
        $count = $product->approvedReviews()->where('rating', $i)->count();
        $distribution[$i] = [
            'count'   => $count,
            'percent' => $totalCount > 0 ? round(($count / $totalCount) * 100) : 0,
        ];
    }
?>

<div class="mt-10" id="reviews-section">

    
    <div class="flex items-center gap-3 mb-6 pb-4 border-b border-base-300">
        <h2 class="text-xl font-black" style="font-family:'Cairo',sans-serif;">
            التقييمات والمراجعات
        </h2>
        <?php if($totalCount > 0): ?>
            <span class="badge badge-warning font-bold"><?php echo e($totalCount); ?> تقييم</span>
        <?php endif; ?>
    </div>

    <?php if($totalCount > 0): ?>
    
    <div class="flex flex-col sm:flex-row gap-6 mb-8 p-5 bg-base-200 rounded-2xl">
        <div class="flex flex-col items-center justify-center flex-shrink-0 min-w-[120px]">
            <span class="text-5xl font-black text-warning"><?php echo e($avgRating); ?></span>
            <div class="flex gap-0.5 my-1">
                <?php for($i = 1; $i <= 5; $i++): ?>
                    <svg class="w-5 h-5 <?php echo e($i <= round($avgRating) ? 'text-warning' : 'text-base-300'); ?>"
                         fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                    </svg>
                <?php endfor; ?>
            </div>
            <span class="text-xs text-base-content/50">من 5</span>
        </div>

        <div class="flex flex-col gap-1.5 flex-1 justify-center">
            <?php $__currentLoopData = $distribution; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $star => $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="flex items-center gap-2">
                    <span class="text-xs font-bold w-3 text-base-content/60"><?php echo e($star); ?></span>
                    <svg class="w-3.5 h-3.5 text-warning flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                    </svg>
                    <div class="flex-1 bg-base-300 rounded-full h-2 overflow-hidden">
                        <div class="bg-warning h-2 rounded-full transition-all duration-500"
                             style="width: <?php echo e($data['percent']); ?>%"></div>
                    </div>
                    <span class="text-xs text-base-content/50 w-8 text-left"><?php echo e($data['count']); ?></span>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
    <?php endif; ?>

    
    <?php if(auth()->guard()->check()): ?>
        <?php if($canReview): ?>
        <div class="card bg-base-100 border border-base-300 mb-8">
            <div class="card-body p-5">
                <h3 class="font-black text-base mb-4" style="font-family:'Cairo',sans-serif;">أضف تقييمك</h3>
                <form action="<?php echo e(route('product.reviews.store', $product->id)); ?>" method="POST">
                    <?php echo csrf_field(); ?>

                    
                    <div class="mb-4">
                        <div class="flex items-center gap-1" id="star-container" dir="rtl">
                            <?php for($i = 5; $i >= 1; $i--): ?>
                                <input type="radio" name="rating" value="<?php echo e($i); ?>"
                                       id="star<?php echo e($i); ?>" class="hidden"
                                       <?php echo e(old('rating') == $i ? 'checked' : ''); ?>>
                                <label for="star<?php echo e($i); ?>"
                                       class="star-label cursor-pointer text-3xl transition-colors select-none"
                                       data-value="<?php echo e($i); ?>"
                                       style="color: <?php echo e(old('rating') >= $i ? 'oklch(var(--wa))' : 'oklch(var(--bc) / 0.2)'); ?>">
                                    ★
                                </label>
                            <?php endfor; ?>
                            <span class="text-sm text-base-content/50 mr-2" id="star-text">
                                <?php echo e(old('rating') ? ['','سيء','مقبول','جيد','جيد جداً','ممتاز'][old('rating')] : 'اختر تقييمك'); ?>

                            </span>
                        </div>
                    </div>

                    <?php $__errorArgs = ['rating'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="text-error text-xs mb-3"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                    <textarea name="comment" rows="3"
                              placeholder="شاركنا رأيك في المنتج... (اختياري)"
                              class="textarea textarea-bordered w-full text-sm resize-none"
                              maxlength="1000"><?php echo e(old('comment')); ?></textarea>
                    <?php $__errorArgs = ['comment'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="text-error text-xs mt-1"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                    <div class="flex justify-end mt-3">
                        <button type="submit" class="btn btn-warning btn-sm font-black gap-2">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                            </svg>
                            إرسال التقييم
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <?php elseif($userReview): ?>
        <div class="card bg-warning/10 border border-warning/30 mb-8">
            <div class="card-body p-4">
                <div class="flex items-center justify-between flex-wrap gap-3">
                    <div>
                        <p class="text-sm font-bold mb-1">تقييمك للمنتج</p>
                        <div class="flex gap-0.5">
                            <?php for($i = 1; $i <= 5; $i++): ?>
                                <svg class="w-4 h-4 <?php echo e($i <= $userReview->rating ? 'text-warning' : 'text-base-300'); ?>"
                                     fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                            <?php endfor; ?>
                        </div>
                        <?php if($userReview->comment): ?>
                            <p class="text-sm text-base-content/70 mt-1"><?php echo e($userReview->comment); ?></p>
                        <?php endif; ?>
                        <?php if(!$userReview->is_approved): ?>
                            <span class="badge badge-warning badge-sm mt-1">في انتظار المراجعة</span>
                        <?php endif; ?>
                    </div>
                    <form action="<?php echo e(route('product.reviews.destroy', $product->id)); ?>" method="POST">
                        <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                        <button type="submit"
                                class="btn btn-ghost btn-sm text-error hover:bg-error/10"
                                onclick="return confirm('هتحذف تقييمك؟')">
                            <i class="fa-solid fa-trash fa-sm"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
        <?php endif; ?>

    <?php else: ?>
        <div class="alert mb-6 bg-base-200 border border-base-300">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <span class="text-sm">
                <a href="<?php echo e(route('login')); ?>" class="text-warning font-bold hover:underline">سجل دخول</a>
                لإضافة تقييمك
            </span>
        </div>
    <?php endif; ?>

    
    <?php if($reviews->isEmpty()): ?>
        <div class="text-center py-10 text-base-content/40">
            <svg class="w-10 h-10 mx-auto mb-3 opacity-30" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                <path stroke-linecap="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
            </svg>
            <p class="text-sm">لا توجد تقييمات بعد — كن أول من يقيّم!</p>
        </div>
    <?php else: ?>
        <div class="flex flex-col gap-4">
            <?php $__currentLoopData = $reviews; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $review): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="flex gap-3 pb-4 border-b border-base-200 last:border-0">
                    <div class="w-9 h-9 rounded-full bg-warning/20 flex items-center justify-center
                                flex-shrink-0 font-black text-warning text-sm">
                        <?php echo e(strtoupper(substr($review->user->name, 0, 1))); ?>

                    </div>
                    <div class="flex-1">
                        <div class="flex items-center justify-between flex-wrap gap-1 mb-1">
                            <span class="font-bold text-sm"><?php echo e($review->user->name); ?></span>
                            <span class="text-xs text-base-content/40"><?php echo e($review->created_at->diffForHumans()); ?></span>
                        </div>
                        <div class="flex gap-0.5 mb-1">
                            <?php for($i = 1; $i <= 5; $i++): ?>
                                <svg class="w-3.5 h-3.5 <?php echo e($i <= $review->rating ? 'text-warning' : 'text-base-300'); ?>"
                                     fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                            <?php endfor; ?>
                        </div>
                        <?php if($review->comment): ?>
                            <p class="text-sm text-base-content/75 leading-relaxed"><?php echo e($review->comment); ?></p>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    <?php endif; ?>

</div>

<?php if (! $__env->hasRenderedOnce('8fd75874-9fbe-4476-874c-a10bc5949cbd')): $__env->markAsRenderedOnce('8fd75874-9fbe-4476-874c-a10bc5949cbd'); ?>
<?php $__env->startPush('scripts'); ?>
<script>
(function () {
    const texts   = ['', 'سيء', 'مقبول', 'جيد', 'جيد جداً', 'ممتاز'];
    const labels  = document.querySelectorAll('#star-container .star-label');
    const starText = document.getElementById('star-text');

    if (!labels.length) return;

    const colorOn  = 'oklch(var(--wa))';
    const colorOff = 'oklch(var(--bc) / 0.2)';

    function paint(upTo) {
        labels.forEach(l => {
            l.style.color = parseInt(l.dataset.value) <= upTo ? colorOn : colorOff;
        });
    }

    function currentSelected() {
        const checked = document.querySelector('#star-container input[name="rating"]:checked');
        return checked ? parseInt(checked.value) : 0;
    }

    labels.forEach(label => {
        label.addEventListener('mouseenter', () => paint(parseInt(label.dataset.value)));
        label.addEventListener('mouseleave', () => paint(currentSelected()));
        label.addEventListener('click', () => {
            const val = parseInt(label.dataset.value);
            paint(val);
            if (starText) starText.textContent = texts[val] || '';
        });
    });
})();
</script>
<?php $__env->stopPush(); ?>
<?php endif; ?>
<?php /**PATH C:\Users\USER\Herd\electric-store-api\resources\views/components/product-reviews.blade.php ENDPATH**/ ?>