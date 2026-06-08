<!DOCTYPE html>
<html lang="ar" dir="rtl" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <meta name="description" content="<?php echo e($description ?? 'متجر إلكتروني شامل للأدوات الكهربائية'); ?>">
    <meta name="keywords" content="متجر إلكتروني, أدوات كهربائية, إلكترونيات, تسوق">
    <link rel="icon" type="image/x-icon" href="<?php echo e(asset('favicon.ico')); ?>">
    <link rel="canonical" href="<?php echo e(url()->current()); ?>">
    <script>
        (function() {
            const saved = localStorage.getItem('theme') || 'dark';
            document.documentElement.setAttribute('data-theme', saved);
        })();
    </script>
    <title><?php echo e($title ?? 'المتجر الكهربائي'); ?></title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700;900&family=Tajawal:wght@300;400;700;900&display=swap" rel="stylesheet">

    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>


    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    
    <?php echo $__env->yieldPushContent('kashier'); ?>

    <?php echo $__env->yieldPushContent('styles'); ?>

    <meta name="format-detection" content="telephone=no">
    <meta name="theme-color" content="#c9a96e">
    <meta name="msapplication-TileColor" content="#c9a96e">
    <meta http-equiv="X-Content-Type-Options" content="nosniff">
    <meta http-equiv="X-Frame-Options" content="DENY">
    <meta http-equiv="X-XSS-Protection" content="1; mode=block">
    <meta http-equiv="Referrer-Policy" content="strict-origin-when-cross-origin">
</head>
<body>
    
    <a href="#main-content" class="skip-link sr-only focus:not-sr-only focus:absolute focus:top-4 focus:left-4 bg-accent text-white px-4 py-2 rounded z-50">
        انتقل إلى المحتوى الرئيسي
    </a>

<?php if (isset($component)) { $__componentOriginal850419188ae35167c7319eecf5d82db1 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal850419188ae35167c7319eecf5d82db1 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.nav-bar','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('nav-bar'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal850419188ae35167c7319eecf5d82db1)): ?>
<?php $attributes = $__attributesOriginal850419188ae35167c7319eecf5d82db1; ?>
<?php unset($__attributesOriginal850419188ae35167c7319eecf5d82db1); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal850419188ae35167c7319eecf5d82db1)): ?>
<?php $component = $__componentOriginal850419188ae35167c7319eecf5d82db1; ?>
<?php unset($__componentOriginal850419188ae35167c7319eecf5d82db1); ?>
<?php endif; ?>

    
    <?php if(session('success') || session('error')): ?>
    <div class="flash-container" id="flashContainer">
        <?php if(session('success')): ?>
        <div class="flash-success">
            <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" d="M5 13l4 4L19 7"/>
            </svg>
            <?php echo e(session('success')); ?>

            <button class="flash-close" onclick="document.getElementById('flashContainer').remove()">✕</button>
        </div>
        <?php endif; ?>
        <?php if(session('error')): ?>
        <div class="flash-error">
            <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" d="M6 18L18 6M6 6l12 12"/>
            </svg>
            <?php echo e(session('error')); ?>

            <button class="flash-close" onclick="document.getElementById('flashContainer').remove()">✕</button>
        </div>
        <?php endif; ?>
    </div>
    <?php endif; ?>

    
    <main class="main-content" id="main-content">
        <?php echo e($slot); ?>

    </main>

    <?php if (isset($component)) { $__componentOriginal8a8716efb3c62a45938aca52e78e0322 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8a8716efb3c62a45938aca52e78e0322 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.footer','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('footer'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal8a8716efb3c62a45938aca52e78e0322)): ?>
<?php $attributes = $__attributesOriginal8a8716efb3c62a45938aca52e78e0322; ?>
<?php unset($__attributesOriginal8a8716efb3c62a45938aca52e78e0322); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8a8716efb3c62a45938aca52e78e0322)): ?>
<?php $component = $__componentOriginal8a8716efb3c62a45938aca52e78e0322; ?>
<?php unset($__componentOriginal8a8716efb3c62a45938aca52e78e0322); ?>
<?php endif; ?>

    <script>
    // DOM ready helper
    function domReady(fn) {
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', fn);
        } else {
            fn();
        }
    }

    domReady(() => {
        // Scroll effect for navigation
        const mainNav = document.getElementById('mainNav');
        if (mainNav) {
            window.addEventListener('scroll', () => {
                mainNav.classList.toggle('scrolled', window.scrollY > 20);
            });
        }

        // User menu toggle
        function toggleUserMenu() {
            const menu = document.getElementById('userMenu');
            if (menu) {
                menu.style.display = menu.style.display === 'none' ? 'block' : 'none';
            }
        }

        // Mobile menu toggle
        function toggleMobileMenu() {
            const menu = document.getElementById('mobileMenu');
            if (menu) {
                menu.style.display = menu.style.display === 'none' ? 'block' : 'none';
            }
        }

        // Click outside to close menus
        document.addEventListener('click', (e) => {
            // Close user menu
            if (!e.target.closest('[onclick="toggleUserMenu()"]') && !e.target.closest('#userMenu')) {
                const userMenu = document.getElementById('userMenu');
                if (userMenu) userMenu.style.display = 'none';
            }

            // Close mobile menu
            if (!e.target.closest('[onclick="toggleMobileMenu()"]') && !e.target.closest('#mobileMenu')) {
                const mobileMenu = document.getElementById('mobileMenu');
                if (mobileMenu) mobileMenu.style.display = 'none';
            }
        });

        // Auto-hide flash messages
        const flashContainer = document.getElementById('flashContainer');
        if (flashContainer) {
            setTimeout(() => {
                flashContainer.style.transition = 'opacity 0.5s';
                flashContainer.style.opacity = '0';
                setTimeout(() => flashContainer.remove(), 500);
            }, 4000);
        }

        // Make functions globally available
        window.toggleUserMenu = toggleUserMenu;
        window.toggleMobileMenu = toggleMobileMenu;
    });
    </script>

    
    <?php echo $__env->yieldPushContent('scripts'); ?>

</body>
</html>
<?php /**PATH C:\Users\USER\Herd\electric-store-api\resources\views/components/layout.blade.php ENDPATH**/ ?>