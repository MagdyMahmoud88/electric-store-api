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

<div class="font-cairo bg-base-100 text-base-content rtl overflow-x-hidden min-h-screen">
    <?php if (isset($component)) { $__componentOriginal0f26c0e6815eac85fc5ae74670389ce5 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0f26c0e6815eac85fc5ae74670389ce5 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.welcome.hero','data' => ['latestProducts' => $latestProducts]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('welcome.hero'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['latestProducts' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($latestProducts)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal0f26c0e6815eac85fc5ae74670389ce5)): ?>
<?php $attributes = $__attributesOriginal0f26c0e6815eac85fc5ae74670389ce5; ?>
<?php unset($__attributesOriginal0f26c0e6815eac85fc5ae74670389ce5); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal0f26c0e6815eac85fc5ae74670389ce5)): ?>
<?php $component = $__componentOriginal0f26c0e6815eac85fc5ae74670389ce5; ?>
<?php unset($__componentOriginal0f26c0e6815eac85fc5ae74670389ce5); ?>
<?php endif; ?>
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
    <?php if (isset($component)) { $__componentOriginal0c2462c045b3b2cd1950667bc5b8c565 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0c2462c045b3b2cd1950667bc5b8c565 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.welcome.offers','data' => ['discountedProducts' => $discountedProducts]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('welcome.offers'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['discountedProducts' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($discountedProducts)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal0c2462c045b3b2cd1950667bc5b8c565)): ?>
<?php $attributes = $__attributesOriginal0c2462c045b3b2cd1950667bc5b8c565; ?>
<?php unset($__attributesOriginal0c2462c045b3b2cd1950667bc5b8c565); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal0c2462c045b3b2cd1950667bc5b8c565)): ?>
<?php $component = $__componentOriginal0c2462c045b3b2cd1950667bc5b8c565; ?>
<?php unset($__componentOriginal0c2462c045b3b2cd1950667bc5b8c565); ?>
<?php endif; ?>
    <?php if (isset($component)) { $__componentOriginal5fd67284f8de08db0478ff39bd9f2247 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5fd67284f8de08db0478ff39bd9f2247 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.welcome.latest-products','data' => ['latestProducts' => $latestProducts]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('welcome.latest-products'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['latestProducts' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($latestProducts)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5fd67284f8de08db0478ff39bd9f2247)): ?>
<?php $attributes = $__attributesOriginal5fd67284f8de08db0478ff39bd9f2247; ?>
<?php unset($__attributesOriginal5fd67284f8de08db0478ff39bd9f2247); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5fd67284f8de08db0478ff39bd9f2247)): ?>
<?php $component = $__componentOriginal5fd67284f8de08db0478ff39bd9f2247; ?>
<?php unset($__componentOriginal5fd67284f8de08db0478ff39bd9f2247); ?>
<?php endif; ?>
    <?php if (isset($component)) { $__componentOriginald38e1469462f33af4a6708fcb0fc965b = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald38e1469462f33af4a6708fcb0fc965b = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.welcome.features','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('welcome.features'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald38e1469462f33af4a6708fcb0fc965b)): ?>
<?php $attributes = $__attributesOriginald38e1469462f33af4a6708fcb0fc965b; ?>
<?php unset($__attributesOriginald38e1469462f33af4a6708fcb0fc965b); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald38e1469462f33af4a6708fcb0fc965b)): ?>
<?php $component = $__componentOriginald38e1469462f33af4a6708fcb0fc965b; ?>
<?php unset($__componentOriginald38e1469462f33af4a6708fcb0fc965b); ?>
<?php endif; ?>
    <?php if (isset($component)) { $__componentOriginalba9743b4e7e26f10380d466383df5ca7 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalba9743b4e7e26f10380d466383df5ca7 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.welcome.reviews','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('welcome.reviews'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalba9743b4e7e26f10380d466383df5ca7)): ?>
<?php $attributes = $__attributesOriginalba9743b4e7e26f10380d466383df5ca7; ?>
<?php unset($__attributesOriginalba9743b4e7e26f10380d466383df5ca7); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalba9743b4e7e26f10380d466383df5ca7)): ?>
<?php $component = $__componentOriginalba9743b4e7e26f10380d466383df5ca7; ?>
<?php unset($__componentOriginalba9743b4e7e26f10380d466383df5ca7); ?>
<?php endif; ?>
    <?php if (isset($component)) { $__componentOriginal4b1eeba0fe4d9934c4dc74dfdd6a3126 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal4b1eeba0fe4d9934c4dc74dfdd6a3126 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.welcome.categories','data' => ['categories' => $categories]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('welcome.categories'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['categories' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($categories)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal4b1eeba0fe4d9934c4dc74dfdd6a3126)): ?>
<?php $attributes = $__attributesOriginal4b1eeba0fe4d9934c4dc74dfdd6a3126; ?>
<?php unset($__attributesOriginal4b1eeba0fe4d9934c4dc74dfdd6a3126); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal4b1eeba0fe4d9934c4dc74dfdd6a3126)): ?>
<?php $component = $__componentOriginal4b1eeba0fe4d9934c4dc74dfdd6a3126; ?>
<?php unset($__componentOriginal4b1eeba0fe4d9934c4dc74dfdd6a3126); ?>
<?php endif; ?>
    <?php if (isset($component)) { $__componentOriginal28813d2630e2ca42e1387bdfef56c0d0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal28813d2630e2ca42e1387bdfef56c0d0 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.welcome.cta','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('welcome.cta'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal28813d2630e2ca42e1387bdfef56c0d0)): ?>
<?php $attributes = $__attributesOriginal28813d2630e2ca42e1387bdfef56c0d0; ?>
<?php unset($__attributesOriginal28813d2630e2ca42e1387bdfef56c0d0); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal28813d2630e2ca42e1387bdfef56c0d0)): ?>
<?php $component = $__componentOriginal28813d2630e2ca42e1387bdfef56c0d0; ?>
<?php unset($__componentOriginal28813d2630e2ca42e1387bdfef56c0d0); ?>
<?php endif; ?>

</div>

<script>
const observer = new IntersectionObserver(entries => {
    entries.forEach(e => {
        if (e.isIntersecting) { e.target.classList.add('visible'); observer.unobserve(e.target); }
    });
}, { threshold: 0.12 });
document.querySelectorAll('.reveal').forEach(el => observer.observe(el));

function animateCounter(el, target, duration = 1800) {
    let start = 0;
    const step = target / (duration / 16);
    const timer = setInterval(() => {
        start += step;
        if (start >= target) { el.textContent = '+' + target.toLocaleString(); clearInterval(timer); }
        else { el.textContent = '+' + Math.floor(start).toLocaleString(); }
    }, 16);
}
const counterObs = new IntersectionObserver(entries => {
    entries.forEach(e => {
        if (e.isIntersecting) {
            animateCounter(e.target, parseInt(e.target.dataset.target));
            counterObs.unobserve(e.target);
        }
    });
}, { threshold: 0.5 });
document.querySelectorAll('[data-target]').forEach(el => counterObs.observe(el));
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
<?php /**PATH C:\Users\USER\Herd\electric-store-api\resources\views/welcome.blade.php ENDPATH**/ ?>