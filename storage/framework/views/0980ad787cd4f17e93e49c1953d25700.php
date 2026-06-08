
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

    
    <div class="admin-bar sticky top-[64px] z-40 w-full">
        <div class="page-container">
            <div class="admin-bar__inner">
                <div class="admin-bar__brand">
                    <div class="admin-bar__icon">
                        <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </div>
                    <span class="admin-bar__title">إدارة المستخدمين</span>
                </div>
                <a href="<?php echo e(route('admin.dashboard')); ?>" class="admin-nav-link">← لوحة التحكم</a>
            </div>
        </div>
    </div>

    <div class="page-container" style="padding-top:32px;padding-bottom:32px;">

        
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-card__icon stat-card__icon--blue">
                    <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
                <div>
                    <p class="stat-card__val"><?php echo e($stats['total']); ?></p>
                    <p class="stat-card__label">إجمالي المستخدمين</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-card__icon stat-card__icon--green">
                </div>
                <div>
                    <p class="stat-card__val"><?php echo e($stats['active']); ?></p>
                    <p class="stat-card__label">مفعّلين</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-card__icon stat-card__icon--red">
                </div>
                <div>
                    <p class="stat-card__val <?php echo e($stats['inactive'] > 0 ? 'text-red-400' : ''); ?>"><?php echo e($stats['inactive']); ?></p>
                    <p class="stat-card__label">معطّلين</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-card__icon stat-card__icon--amber">
                </div>
                <div>
                    <p class="stat-card__val <?php echo e($stats['unverified'] > 0 ? 'text-amber-400' : ''); ?>"><?php echo e($stats['unverified']); ?></p>
                    <p class="stat-card__label">غير متحققين</p>
                </div>
            </div>
        </div>

        
        <form method="GET" class="dash-card" style="padding:16px 18px;">
            <div style="display:flex;flex-wrap:wrap;gap:12px;align-items:flex-end;">

                <div style="flex:1;min-width:180px;">
                    <label style="font-size:11px;color:var(--text-muted);display:block;margin-bottom:4px;">بحث</label>
                    <div class="search-field">
                        <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <circle cx="11" cy="11" r="8"/><path stroke-linecap="round" d="M21 21l-4.35-4.35"/>
                        </svg>
                        <input type="text" name="search" value="<?php echo e(request('search')); ?>" placeholder="الاسم أو الإيميل...">
                    </div>
                </div>

                <?php $__currentLoopData = [
                    ['name' => 'status',   'label' => 'الحالة',  'options' => ['' => 'الكل', 'active' => 'مفعّل', 'inactive' => 'معطّل']],
                    ['name' => 'verified', 'label' => 'التحقق',  'options' => ['' => 'الكل', 'yes' => 'متحقق', 'no' => 'غير متحقق']],
                    ['name' => 'role',     'label' => 'الدور',   'options' => ['' => 'الكل', 'user' => 'User', 'admin' => 'Admin']],
                    ['name' => 'sort',     'label' => 'ترتيب',   'options' => ['latest' => 'الأحدث', 'oldest' => 'الأقدم', 'name' => 'الاسم', 'orders' => 'الطلبات', 'spent' => 'الإنفاق']],
                ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $filter): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div>
                        <label style="font-size:11px;color:var(--text-muted);display:block;margin-bottom:4px;"><?php echo e($filter['label']); ?></label>
                        <select name="<?php echo e($filter['name']); ?>"
                                style="font-size:13px;padding:7px 12px;border-radius:8px;background:var(--surface2);border:1px solid var(--border);color:var(--text);outline:none;">
                            <?php $__currentLoopData = $filter['options']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($val); ?>" <?php echo e(request($filter['name']) == $val ? 'selected' : ''); ?>><?php echo e($label); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                <div style="display:flex;gap:8px;">
                    <button type="submit" class="action-btn action-btn--edit">🔍 بحث</button>
                    <a href="<?php echo e(route('admin.users.index')); ?>" class="action-btn" style="background:var(--surface2);color:var(--text-muted);border:1px solid var(--border);">✖ مسح</a>
                </div>
            </div>
        </form>

        
        <div class="dash-card">
            <div class="dash-card__head">
                <div>
                    <p class="dash-card__title">المستخدمين</p>
                    <p class="dash-card__sub"><?php echo e($users->total()); ?> مستخدم</p>
                </div>
            </div>

            <div style="overflow-x:auto;">
                <table class="products-table">
                    <thead>
                    <tr>
                        <th>المستخدم</th>
                        <th>الحالة</th>
                        <th>الطلبات</th>
                        <th>الإنفاق</th>
                        <th>التسجيل</th>
                        <th>إجراءات</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            
                            <td>
                                <div class="prod-cell">
                                    <div style="width:36px;height:36px;border-radius:50%;background:var(--electric-dim);color:var(--electric);display:flex;align-items:center;justify-content:center;font-size:13px;font-weight:800;flex-shrink:0;">
                                        <?php echo e(strtoupper(substr($user->name, 0, 1))); ?>

                                    </div>
                                    <div>
                                        <p class="prod-cell__name"><?php echo e($user->name); ?></p>
                                        <p class="prod-cell__id"><?php echo e($user->email); ?></p>
                                    </div>
                                </div>
                            </td>

                            
                            <td>
                                <div style="display:flex;flex-direction:column;gap:4px;">
                                    <span class="stock-badge <?php echo e($user->is_active ? 'stock-badge--ok' : 'stock-badge--none'); ?>">
                                        <?php echo e($user->is_active ? 'مفعّل' : 'معطّل'); ?>

                                    </span>
                                    <span class="stock-badge <?php echo e($user->email_verified_at ? 'stock-badge--ok' : 'stock-badge--low'); ?>">
                                        <?php echo e($user->email_verified_at ? '✅ متحقق' : '⚠️ غير متحقق'); ?>

                                    </span>
                                </div>
                            </td>

                            
                            <td style="text-align:center;font-weight:700;color:var(--text);">
                                <?php echo e($user->orders_count); ?>

                            </td>

                            
                            <td>
                                <span class="price-val"><?php echo e(number_format($user->orders_sum_total ?? 0, 0)); ?> ج.م</span>
                            </td>

                            
                            <td style="font-size:12px;color:var(--text-muted);">
                                <?php echo e($user->created_at->format('d M Y')); ?>

                            </td>

                            
                            <td>
                                <div class="action-btns">
                                    <a href="<?php echo e(route('admin.users.show', $user)); ?>" class="action-btn action-btn--edit">
                                        👁 عرض
                                    </a>
                                    <?php if (! ($user->isAdmin())): ?>
                                        <form action="<?php echo e(route('admin.users.toggle-status', $user)); ?>" method="POST">
                                            <?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
                                            <button type="submit" class="action-btn <?php echo e($user->is_active ? 'action-btn--delete' : 'action-btn--edit'); ?>">
                                                <?php echo e($user->is_active ? '🔒' : '✅'); ?>

                                            </button>
                                        </form>
                                        <form action="<?php echo e(route('admin.users.destroy', $user)); ?>" method="POST"
                                              onsubmit="return confirm('حذف <?php echo e(addslashes($user->name)); ?>؟')">
                                            <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                            <button type="submit" class="action-btn action-btn--delete">🗑</button>
                                        </form>
                                    <?php else: ?>
                                        <span class="tag tag--purple">Admin</span>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="6" style="text-align:center;padding:48px;color:var(--text-muted);">
                                <p style="font-size:32px;margin-bottom:8px;">👥</p>
                                <p style="font-size:13px;">لا توجد نتائج</p>
                            </td>
                        </tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <?php if($users->hasPages()): ?>
                <div class="pagination-wrap">
                    <?php echo e($users->withQueryString()->links()); ?>

                </div>
            <?php endif; ?>
        </div>

    </div>

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
<?php /**PATH C:\Users\USER\Herd\electric-store-api\resources\views/admin/users/index.blade.php ENDPATH**/ ?>