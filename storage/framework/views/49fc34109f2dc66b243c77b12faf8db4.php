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
     <?php $__env->slot('title', null, []); ?> الملف الشخصي <?php $__env->endSlot(); ?>

    <div class="min-h-screen bg-base-100 pb-20 family-cairo text-right" dir="rtl">

        
        <div class="bg-base-200 border-b border-base-300 pt-10 pb-16 px-4">
            <div class="max-w-5xl mx-auto flex flex-col md:flex-row items-center gap-6">

                
                <div class="relative flex-shrink-0">
                    <div class="w-20 h-20 rounded-full bg-primary flex items-center justify-center text-primary-content text-3xl font-bold ring-2 ring-base-300">
                        <?php echo e(strtoupper(substr(auth()->user()->name, 0, 1))); ?>

                    </div>
                    <span class="absolute bottom-0.5 left-0.5 w-3.5 h-3.5 rounded-full bg-success border-2 border-base-200"></span>
                </div>

                
                <div class="flex-1 text-center md:text-right">
                    <h1 class="text-2xl font-bold text-base-content mb-1"><?php echo e(auth()->user()->name); ?></h1>
                    <p class="text-base-content/50 text-sm mb-3"><?php echo e(auth()->user()->email); ?></p>
                    <span class="inline-flex items-center gap-1.5 text-xs text-base-content/50 bg-base-300 border border-base-300 rounded-full px-3 py-1.5">
                        <i class="fa-regular fa-calendar-check text-primary text-xs"></i>
                        عضو منذ <?php echo e(auth()->user()->created_at->format('Y')); ?>

                    </span>
                </div>

            </div>
        </div>

        
        <div class="max-w-5xl mx-auto px-4 -mt-8 relative z-10">

            
            <div class="grid grid-cols-3 gap-3 mb-6">

                <a href="<?php echo e(route('orders.index')); ?>"
                   class="group bg-base-100 border border-base-300 hover:border-primary/40 rounded-2xl p-4 flex items-center gap-3 transition-colors duration-200">
                    <div class="w-10 h-10 rounded-xl bg-primary/10 text-primary flex items-center justify-center text-base group-hover:bg-primary group-hover:text-primary-content transition-colors duration-200 flex-shrink-0">
                        <i class="fa-solid fa-box-open"></i>
                    </div>
                    <div>
                        <div class="text-base-content/40 text-xs">الطلبات</div>
                        <div class="text-xl font-bold text-base-content"><?php echo e(auth()->user()->orders()->count()); ?></div>
                    </div>
                </a>

                <a href="<?php echo e(route('wishlist.index')); ?>"
                   class="group bg-base-100 border border-base-300 hover:border-secondary/40 rounded-2xl p-4 flex items-center gap-3 transition-colors duration-200">
                    <div class="w-10 h-10 rounded-xl bg-secondary/10 text-secondary flex items-center justify-center text-base group-hover:bg-secondary group-hover:text-secondary-content transition-colors duration-200 flex-shrink-0">
                        <i class="fa-solid fa-heart"></i>
                    </div>
                    <div>
                        <div class="text-base-content/40 text-xs">المفضلة</div>
                        <div class="text-xl font-bold text-base-content"><?php echo e(auth()->user()->wishlists()->count()); ?></div>
                    </div>
                </a>

                <a href="<?php echo e(route('profile.reviews')); ?>"
                   class="group bg-base-100 border border-base-300 hover:border-accent/40 rounded-2xl p-4 flex items-center gap-3 transition-colors duration-200">
                    <div class="w-10 h-10 rounded-xl bg-accent/10 text-accent flex items-center justify-center text-base group-hover:bg-accent group-hover:text-accent-content transition-colors duration-200 flex-shrink-0">
                        <i class="fa-solid fa-star"></i>
                    </div>
                    <div>
                        <div class="text-base-content/40 text-xs">تقييماتي</div>
                        <div class="text-xl font-bold text-base-content"><?php echo e(auth()->user()->reviews()->count()); ?></div>
                    </div>
                </a>

            </div>

            
            <div class="bg-base-100 rounded-2xl border border-base-300 overflow-hidden">

                
                <div class="flex gap-1 p-1.5 bg-base-200 border-b border-base-300">
                    <button onclick="switchProfileTab('info')" id="btn-info"
                            class="flex-1 py-3 rounded-xl text-sm font-semibold transition-all duration-200 flex items-center justify-center gap-2 active-profile-tab">
                        <i class="fa-solid fa-user-edit"></i> البيانات الأساسية
                    </button>
                    <button onclick="switchProfileTab('password')" id="btn-password"
                            class="flex-1 py-3 rounded-xl text-sm font-semibold text-base-content/40 hover:text-base-content hover:bg-base-300 transition-all duration-200 flex items-center justify-center gap-2">
                        <i class="fa-solid fa-shield-halved"></i> الأمان والخصوصية
                    </button>
                </div>

                <div class="p-6 md:p-8">

                    <?php if(session('success')): ?>
                        <div class="flex items-center gap-3 bg-success/10 border border-success/30 text-success rounded-xl px-4 py-3 text-sm mb-6">
                            <i class="fa-solid fa-circle-check flex-shrink-0"></i>
                            <span><?php echo e(session('success')); ?></span>
                        </div>
                    <?php endif; ?>

                    
                    <div id="panel-info" class="tab-panel">
                        <p class="text-xs font-semibold text-base-content/30 uppercase tracking-widest mb-5">المعلومات الشخصية</p>
                        <form action="<?php echo e(route('profile.update')); ?>" method="POST">
                            <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-6">

                                <div>
                                    <label class="block text-xs font-medium text-base-content/60 mb-2">الاسم الكامل</label>
                                    <div class="relative">
                                        <i class="fa-solid fa-user absolute right-3 top-1/2 -translate-y-1/2 text-base-content/20 text-sm pointer-events-none"></i>
                                        <input type="text" name="name" value="<?php echo e(old('name', auth()->user()->name)); ?>"
                                               class="w-full pr-9 pl-3 py-2.5 bg-base-200 border border-base-300 rounded-xl text-sm text-base-content focus:border-primary focus:ring-2 focus:ring-primary/10 outline-none transition-all" />
                                    </div>
                                    <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-error text-xs mt-1.5"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>

                                <div class="opacity-50">
                                    <label class="block text-xs font-medium text-base-content/60 mb-2">البريد الإلكتروني</label>
                                    <div class="relative">
                                        <i class="fa-solid fa-lock absolute right-3 top-1/2 -translate-y-1/2 text-base-content/20 text-sm pointer-events-none"></i>
                                        <input type="email" value="<?php echo e(auth()->user()->email); ?>" disabled
                                               class="w-full pr-9 pl-3 py-2.5 bg-base-300 border border-base-300 rounded-xl text-sm text-base-content/40 cursor-not-allowed" />
                                    </div>
                                </div>

                            </div>

                            <div class="border-t border-base-300 pt-5 flex items-center gap-3">
                                <button type="submit"
                                        class="inline-flex items-center gap-2 bg-primary text-primary-content text-sm font-semibold px-6 py-2.5 rounded-xl hover:opacity-90 active:scale-95 transition-all">
                                    <i class="fa-solid fa-check"></i> حفظ التحديثات
                                </button>
                                <a href="<?php echo e(route('profile.index')); ?>"
                                   class="inline-flex items-center gap-2 bg-base-200 border border-base-300 text-base-content/60 text-sm font-medium px-5 py-2.5 rounded-xl hover:border-base-content/20 transition-all">
                                    إلغاء
                                </a>
                            </div>
                        </form>
                    </div>

                    
                    <div id="panel-password" class="tab-panel hidden">
                        <p class="text-xs font-semibold text-base-content/30 uppercase tracking-widest mb-5">تغيير كلمة المرور</p>
                        <form action="<?php echo e(route('profile.password')); ?>" method="POST" class="max-w-md space-y-4">
                            <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>

                            <div>
                                <label class="block text-xs font-medium text-base-content/60 mb-2">كلمة المرور الحالية</label>
                                <div class="relative">
                                    <i class="fa-solid fa-lock absolute right-3 top-1/2 -translate-y-1/2 text-base-content/20 text-sm pointer-events-none"></i>
                                    <input type="password" name="current_password"
                                           class="w-full pr-9 pl-3 py-2.5 bg-base-200 border border-base-300 rounded-xl text-sm text-base-content focus:border-secondary focus:ring-2 focus:ring-secondary/10 outline-none transition-all"
                                           placeholder="••••••••" />
                                </div>
                                <?php $__errorArgs = ['current_password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-error text-xs mt-1.5"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-medium text-base-content/60 mb-2">الكلمة الجديدة</label>
                                    <input type="password" name="password"
                                           class="w-full px-3 py-2.5 bg-base-200 border border-base-300 rounded-xl text-sm text-base-content focus:border-secondary focus:ring-2 focus:ring-secondary/10 outline-none transition-all"
                                           placeholder="••••••••" />
                                    <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-error text-xs mt-1.5"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-base-content/60 mb-2">تأكيد الكلمة</label>
                                    <input type="password" name="password_confirmation"
                                           class="w-full px-3 py-2.5 bg-base-200 border border-base-300 rounded-xl text-sm text-base-content focus:border-secondary focus:ring-2 focus:ring-secondary/10 outline-none transition-all"
                                           placeholder="••••••••" />
                                </div>
                            </div>

                            <div class="pt-2">
                                <button type="submit"
                                        class="inline-flex items-center gap-2 bg-secondary text-secondary-content text-sm font-semibold px-6 py-2.5 rounded-xl hover:opacity-90 active:scale-95 transition-all">
                                    <i class="fa-solid fa-lock-open"></i> تغيير كلمة المرور
                                </button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <?php $__env->startPush('styles'); ?>
        <style>
            .family-cairo { font-family: 'Cairo', sans-serif; }
            .active-profile-tab {
                background: hsl(var(--p));
                color: hsl(var(--pc));
            }
        </style>
    <?php $__env->stopPush(); ?>

    <?php $__env->startPush('scripts'); ?>
        <script>
            function switchProfileTab(tab) {
                document.querySelectorAll('.tab-panel').forEach(p => p.classList.add('hidden'));
                document.getElementById('panel-' + tab).classList.remove('hidden');

                ['info', 'password'].forEach(t => {
                    const btn = document.getElementById('btn-' + t);
                    btn.classList.remove('active-profile-tab');
                    btn.classList.add('text-base-content/40');
                    btn.classList.remove('hover:bg-base-300');
                });

                const active = document.getElementById('btn-' + tab);
                active.classList.add('active-profile-tab');
                active.classList.remove('text-base-content/40');
            }

            <?php if($errors->has('current_password') || $errors->has('password')): ?>
            switchProfileTab('password');
            <?php endif; ?>
        </script>
    <?php $__env->stopPush(); ?>
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
<?php /**PATH C:\Users\USER\Herd\electric-store-api\resources\views/user/profile/index.blade.php ENDPATH**/ ?>