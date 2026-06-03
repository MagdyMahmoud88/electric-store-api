@props(['product' , 'lazy' => true , 'class'=>'w-full h-full object-contain'])

<img
    src="{{ $product->getImageSrc()  }}"
    alt="{{ $product->name }}"
    class={{ $class }}
    loading="{{ $lazy ? 'lazy' : 'eager' }}"
    onerror="this.onerror=null;this.src='{{ $product->getPlaceholder() }}';">
