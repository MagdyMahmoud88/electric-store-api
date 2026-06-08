<?php if (isset($component)) { $__componentOriginal03b6c44728e100ba2673d02906458342 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal03b6c44728e100ba2673d02906458342 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.auth-layout','data' => ['title' => 'أدخل كود التحقق']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('auth-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'أدخل كود التحقق']); ?>

    <div class="auth-card">

        
        <div style="text-align:center;margin-bottom:24px;">
            <div class="auth-badge">
                <svg width="11" height="11" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                </svg>
                التحقق من البريد
            </div>
            <h1 style="font-size:20px;font-weight:800;color:var(--text);margin:0 0 6px;">أدخل كود التحقق</h1>
            <p style="font-size:13px;color:var(--text-muted);margin:0;">
                تم إرسال كود مكوّن من 6 أرقام إلى
                <span style="color:var(--electric);font-weight:700;"><?php echo e($email); ?></span>
            </p>
        </div>

        
        <?php if($errors->any()): ?>
            <div class="auth-alert auth-alert-error" style="margin-bottom:20px;">
                <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="flex-shrink:0;">
                    <path stroke-linecap="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <ul style="margin:0;padding:0;list-style:none;">
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $e): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><li><?php echo e($e); ?></li><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
        <?php endif; ?>

        <form action="<?php echo e(route('verification.verify')); ?>" method="POST" id="otpForm">
            <?php echo csrf_field(); ?>

            
            <div class="otp-grid" style="margin-bottom:24px;">
                <?php for($i = 0; $i < 6; $i++): ?>
                    <input
                        type="text"
                        maxlength="1"
                        inputmode="numeric"
                        pattern="[0-9]"
                        class="otp-input"
                        id="otp_<?php echo e($i); ?>"
                        autocomplete="off"
                    >
                <?php endfor; ?>
            </div>

            
            <input type="hidden" name="otp" id="otpHidden">

            <button type="submit" class="auth-btn" style="margin-bottom:16px;">
                <svg width="17" height="17" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                </svg>
                تحقق من الكود
            </button>
        </form>

        
        <div style="text-align:center;">
            <span style="font-size:13px;color:var(--text-muted);">ما وصلكش الكود؟ </span>
            <form action="<?php echo e(route('verification.resend')); ?>" method="POST" style="display:inline;">
                <?php echo csrf_field(); ?>
                <button type="submit" style="background:none;border:none;cursor:pointer;font-size:13px;font-weight:700;color:var(--electric);font-family:'Cairo',sans-serif;padding:0;">
                    أعد الإرسال
                </button>
            </form>
        </div>

    </div>

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
    // ── OTP inputs navigation ──────────────────────────────────
    const inputs = Array.from({length: 6}, (_, i) => document.getElementById(`otp_${i}`));

    inputs.forEach((input, idx) => {
        input.addEventListener('input', (e) => {
            const val = e.target.value.replace(/\D/g, '');
            e.target.value = val;
            if (val && idx < 5) inputs[idx + 1].focus();
            updateHidden();
        });

        input.addEventListener('keydown', (e) => {
            if (e.key === 'Backspace' && !input.value && idx > 0) {
                inputs[idx - 1].focus();
            }
        });

        input.addEventListener('paste', (e) => {
            e.preventDefault();
            const text = (e.clipboardData || window.clipboardData).getData('text').replace(/\D/g, '');
            text.split('').slice(0, 6).forEach((char, i) => {
                if (inputs[i]) inputs[i].value = char;
            });
            inputs[Math.min(text.length, 5)].focus();
            updateHidden();
        });
    });

    function updateHidden() {
        document.getElementById('otpHidden').value = inputs.map(i => i.value).join('');
    }

    // ── Auto-submit لو اكتملت الـ 6 أرقام ──────────────────────
    inputs[5].addEventListener('input', () => {
        if (inputs.every(i => i.value)) {
            updateHidden();
            document.getElementById('otpForm').submit();
        }
    });

    // Focus أول input
    inputs[0].focus();
</script>
<?php /**PATH C:\Users\USER\Herd\electric-store-api\resources\views/emails/verify-otp.blade.php ENDPATH**/ ?>