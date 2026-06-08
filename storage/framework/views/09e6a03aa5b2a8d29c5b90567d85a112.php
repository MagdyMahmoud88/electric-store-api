<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['product' , 'lazy' => true , 'class'=>'w-full h-full object-contain']));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter((['product' , 'lazy' => true , 'class'=>'w-full h-full object-contain']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<img
    src="<?php echo e($product->getImageSrc()); ?>"
    alt="<?php echo e($product->name); ?>"
    class=<?php echo e($class); ?>

    loading="<?php echo e($lazy ? 'lazy' : 'eager'); ?>"
    onerror="this.onerror=null;this.src='<?php echo e($product->getPlaceholder()); ?>';">
<?php /**PATH C:\Users\USER\Herd\electric-store-api\resources\views/components/product-image.blade.php ENDPATH**/ ?>