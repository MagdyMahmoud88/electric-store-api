<?php if (isset($component)) { $__componentOriginal03b6c44728e100ba2673d02906458342 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal03b6c44728e100ba2673d02906458342 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.auth-layout','data' => ['title' => 'تسجيل الدخول']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('auth-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'تسجيل الدخول']); ?>

    <div class="auth-card">

        
        <div style="text-align:center; margin-bottom:24px;">
            <h1 style="font-size:20px; font-weight:800; color:var(--text); margin:0 0 6px;">مرحباً بعودتك</h1>
            <p style="font-size:13px; color:var(--text-muted); margin:0;">سجّل دخولك للمتابعة</p>
        </div>

        
        <?php if($errors->any()): ?>
            <div class="auth-alert auth-alert-error" style="margin-bottom:20px;">
                <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="flex-shrink:0; margin-top:2px;">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <ul style="margin:0; padding:0; list-style:none; font-size:13px; line-height:1.5;">
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $e): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo e($e); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
        <?php endif; ?>

        <form action="<?php echo e(route('login.store')); ?>" method="POST">
            <?php echo csrf_field(); ?>

            
            <div style="margin-bottom:18px;">
                <label class="auth-label">البريد الإلكتروني</label>
                <div style="position:relative;">
                    <input
                        type="email"
                        name="email"
                        value="<?php echo e(old('email')); ?>"
                        placeholder="mail@example.com"
                        dir="ltr"
                        class="auth-input <?php echo e($errors->has('email') ? 'error' : ''); ?>"
                        style="padding-left:42px; text-align: left;"
                        required
                    >
                    <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"
                         style="position:absolute; left:14px; top:50%; transform:translateY(-50%); color:var(--text-muted); pointer-events:none;">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                </div>
                <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <p class="auth-error"><?php echo e($message); ?></p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            
            <div style="margin-bottom:18px;">
                <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:7px;">
                    <label class="auth-label" style="margin:0;">كلمة المرور</label>
                    <a href="<?php echo e(route('password.request')); ?>" class="auth-link" style="font-size:12px;">
                        نسيت كلمة السر؟
                    </a>
                </div>
                <div style="position:relative;">
                    <input
                        type="password"
                        name="password"
                        id="passwordInput"
                        placeholder="••••••••"
                        dir="ltr"
                        class="auth-input <?php echo e($errors->has('password') ? 'error' : ''); ?>"
                        style="padding-left:42px; padding-right:42px; text-align: left;"
                        required
                    >
                    
                    <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"
                         style="position:absolute; left:14px; top:50%; transform:translateY(-50%); color:var(--text-muted); pointer-events:none;">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                    </svg>

                    
                    <button type="button" onclick="togglePassword()" id="toggleBtn"
                            style="position:absolute; right:14px; top:50%; transform:translateY(-50%); background:none; border:none; cursor:pointer; color:var(--text-muted); padding:0; display:flex; align-items:center;"
                            title="إظهار/إخفاء كلمة المرور">
                        <svg id="eyeIcon" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                    </button>
                </div>
                <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <p class="auth-error"><?php echo e($message); ?></p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            
            <div style="display:flex; align-items:center; gap:8px; margin-bottom:22px;">
                <input type="checkbox" name="remember" id="remember" value="1"
                       style="width:15px; height:15px; accent-color:var(--electric); cursor:pointer;">
                <label for="remember" style="font-size:13px; color:var(--text-soft); cursor:pointer; user-select:none; font-weight:600;">
                    تذكرني على هذا الجهاز
                </label>
            </div>

            
            <button type="submit" class="auth-btn">
                <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                </svg>
                <span>تسجيل الدخول</span>
            </button>
        </form>

        
        <div class="auth-divider">أو</div>

        
        <div style="text-align:center;">
            <span style="font-size:13px; color:var(--text-muted);">ليس لديك حساب؟ </span>
            <a href="<?php echo e(route('register.index')); ?>" class="auth-link">أنشئ حساباً الآن</a>
        </div>

    </div>

    
    <p style="text-align:center; margin-top:18px; font-size:12px; color:var(--text-muted); opacity:0.8;">
        🔒 اتصال مشفر وآمن 100%
    </p>

 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal03b6c44728e100ba2673d02906458342)): ?>
<?php $attributes = $__attributesOriginal03b6c44728e100ba2673d02906458342; ?>
<?php unset($__attributesOriginal03b6c44728e100ba2673d02906458342); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal03b6c44728e100ba2673d02906458342)): ?>
<?php $component = $__componentOriginal03b6c44728e100ba2673d02906458342; ?>
<?php unset($__componentOriginal03b6c44728e100ba2673d02906458342); ?>
<?php endif; ?>


<script>
    function togglePassword() {
        const input = document.getElementById('passwordInput');
        const eyeIcon = document.getElementById('eyeIcon');

        if (input.type === 'password') {
            input.type = 'text';
            // تغيير الـ SVG لتصبح أيقونة العين المشطوبة (Eye Slash)
            eyeIcon.innerHTML = `
                <path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18" />
            `;
        } else {
            input.type = 'password';
            // إرجاع أيقونة العين المفتوحة العادية
            eyeIcon.innerHTML = `
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
            `;
        }
    }
</script>
<?php /**PATH C:\Users\USER\Herd\electric-store-api\resources\views/auth/login.blade.php ENDPATH**/ ?>