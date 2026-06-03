<x-layout>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 py-8" dir="rtl">

        {{-- ── Flash Messages ── --}}
        @if(session('success'))
            <div class="alert alert-success mb-6 shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-5 w-5" fill="none" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-error mb-6 shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-5 w-5" fill="none" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        {{-- ── Header ── --}}
        <div class="flex items-center justify-between mb-7 flex-wrap gap-3">
            <div>
                <h1 class="text-xl font-bold text-base-content">الماركات</h1>
                <p class="text-sm text-base-content/50 mt-0.5">إدارة ماركات الأدوات الكهربائية</p>
            </div>
            <a href="{{ route('admin.brands.create') }}" class="btn btn-primary btn-sm gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                </svg>
                إضافة ماركة
            </a>
        </div>

        {{-- ── Bulk Action Bar ── --}}
        <div id="bulkBar"
             class="hidden items-center gap-3 flex-wrap
                bg-success/10 border border-success/30
                rounded-xl px-4 py-3 mb-5">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-success shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <span id="bulkCount" class="font-bold text-success text-sm">0 محدد</span>

            <form id="bulkActivateForm" method="POST" action="{{ route('admin.brands.bulk-activate') }}">
                @csrf
                <input type="hidden" name="ids" id="bulkActivateIds">
                <button type="submit" class="btn btn-success btn-xs gap-1">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    تفعيل المحددة
                </button>
            </form>

            <form id="bulkHideForm" method="POST" action="{{ route('admin.brands.bulk-hide') }}">
                @csrf
                <input type="hidden" name="ids" id="bulkHideIds">
                <button type="submit" class="btn btn-ghost btn-xs gap-1">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                    </svg>
                    إخفاء المحددة
                </button>
            </form>

            <button type="button" onclick="openBulkDeleteModal()" class="btn btn-error btn-xs gap-1">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                </svg>
                حذف المحددة
            </button>

            <button type="button" onclick="clearSelection()" class="btn btn-ghost btn-xs mr-auto gap-1">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
                إلغاء التحديد
            </button>
        </div>

        {{-- ── Search & Filter ── --}}
        <form method="GET" action="{{ route('admin.brands.index') }}"
              class="bg-base-200 border border-base-300 rounded-xl p-4 mb-6 flex gap-3 flex-wrap items-center">

            <label class="input input-bordered input-sm flex items-center gap-2 flex-1 min-w-48">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 opacity-50" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                <input type="text" name="search" placeholder="ابحث باسم الماركة..."
                       value="{{ request('search') }}" class="grow bg-transparent text-sm">
            </label>

            <select name="status" class="select select-bordered select-sm">
                <option value="">كل الحالات</option>
                <option value="1" @selected(request('status') === '1')>نشط</option>
                <option value="0" @selected(request('status') === '0')>غير نشط</option>
            </select>

            <select name="sort" class="select select-bordered select-sm">
                <option value="created_at" @selected(request('sort', 'created_at') === 'created_at')>الأحدث</option>
                <option value="name"          @selected(request('sort') === 'name')>الاسم أ-ي</option>
                <option value="products_count" @selected(request('sort') === 'products_count')>عدد المنتجات</option>
            </select>

            <select name="dir" class="select select-bordered select-sm">
                <option value="desc" @selected(request('dir', 'desc') === 'desc')>تنازلي</option>
                <option value="asc"  @selected(request('dir') === 'asc')>تصاعدي</option>
            </select>

            <button type="submit" class="btn btn-primary btn-sm">بحث</button>

            @if(request()->hasAny(['search','status','sort','dir']))
                <a href="{{ route('admin.brands.index') }}" class="btn btn-ghost btn-sm">مسح</a>
            @endif
        </form>

        {{-- ── Brands Grid ── --}}
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-4">

            @forelse($brands as $brand)

                <div class="card bg-base-100 border border-base-300 shadow-sm
                        hover:-translate-y-1 hover:shadow-md transition-all duration-200
                        relative overflow-hidden">

                    {{-- Checkbox --}}
                    <div class="absolute top-2 right-2 z-10">
                        <input type="checkbox"
                               class="checkbox checkbox-primary checkbox-xs brand-checkbox"
                               value="{{ $brand->id }}"
                               onchange="updateBulkBar()">
                    </div>

                    <div class="card-body items-center text-center p-4 gap-2.5">

                        {{-- Logo --}}
                        <div class="w-16 h-16 rounded-xl bg-base-200 border border-base-300
                                flex items-center justify-center overflow-hidden flex-shrink-0">
                            @if($brand->logo)
                                <img src="{{ asset('storage/' . $brand->logo) }}"
                                     alt="{{ e($brand->name) }}"
                                     loading="lazy"
                                     class="w-full h-full object-contain">
                            @else
                                <span class="text-lg font-black text-primary">
                                {{ mb_substr($brand->name, 0, 2) }}
                            </span>
                            @endif
                        </div>

                        {{-- Name --}}
                        <p class="font-bold text-sm text-base-content leading-tight">
                            {{ $brand->name }}
                        </p>

                        {{-- Products count --}}
                        <p class="text-xs text-base-content/50">
                            {{ $brand->products_count ?? 0 }} منتج
                        </p>

                        {{-- Discount --}}
                        @if($brand->discount_percentage > 0)
                            <div class="w-full bg-warning/10 border border-warning/30 rounded-lg px-2 py-1.5 flex flex-col items-center gap-0.5">
                            <span class="text-xs font-black text-warning">
                                خصم {{ $brand->discount_percentage }}%
                            </span>
                                <span class="text-[10px] text-base-content/40">
                                @if($brand->discount_expires_at)
                                        ينتهي {{ $brand->discount_expires_at->format('Y/m/d') }}
                                    @else
                                        بدون تاريخ انتهاء
                                    @endif
                            </span>
                            </div>
                        @endif

                        {{-- Status Badge --}}
                        <div class="badge badge-sm gap-1 {{ $brand->is_active ? 'badge-success' : 'badge-ghost' }} font-bold">
                            <span class="w-1.5 h-1.5 rounded-full bg-current"></span>
                            {{ $brand->is_active ? 'نشط' : 'غير نشط' }}
                        </div>

                        {{-- Edit + Toggle --}}
                        <div class="flex gap-1.5 w-full mt-1">
                            <a href="{{ route('admin.brands.edit', $brand) }}"
                               class="btn btn-ghost btn-xs flex-1 gap-1">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                                تعديل
                            </a>

                            <form method="POST"
                                  action="{{ route('admin.brands.toggle-status', $brand) }}"
                                  class="flex-1 toggle-form"
                                  data-name="{{ e($brand->name) }}"
                                  data-action="{{ $brand->is_active ? 'إخفاء' : 'تفعيل' }}">
                                @csrf @method('PATCH')
                                <button type="submit" class="btn btn-ghost btn-xs w-full">
                                    {{ $brand->is_active ? 'إخفاء' : 'تفعيل' }}
                                </button>
                            </form>
                        </div>

                        {{-- Delete --}}
                        <button type="button"
                                class="btn btn-error btn-xs btn-outline w-full gap-1"
                                onclick="openDeleteModal('{{ e($brand->name) }}', '{{ route('admin.brands.destroy', $brand) }}')">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                            حذف
                        </button>

                    </div>
                </div>

            @empty
                <div class="col-span-full flex flex-col items-center py-20 text-base-content/40">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mb-4 opacity-30" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                    </svg>
                    <p class="font-bold text-base text-base-content/60">لا توجد ماركات</p>
                    <p class="text-sm mt-1">ابدأ بإضافة أول ماركة لمتجرك</p>
                </div>
            @endforelse

        </div>

        {{-- ── Pagination ── --}}
        @if($brands->hasPages())
            <div class="flex justify-center mt-8">
                {{ $brands->links() }}
            </div>
        @endif

    </div>

    {{-- ══ Delete Single Modal ══ --}}
    <dialog id="deleteModal" class="modal">
        <div class="modal-box max-w-sm text-center" dir="rtl">
            <div class="flex items-center justify-center w-14 h-14 rounded-full bg-error/10 mx-auto mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-error" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                </svg>
            </div>
            <h3 class="font-bold text-base mb-2">تأكيد الحذف</h3>
            <p class="text-sm text-base-content/60 mb-6" id="deleteModalText">
                هل أنت متأكد من حذف هذه الماركة؟
            </p>
            <div class="flex gap-3 justify-center">
                <button class="btn btn-ghost btn-sm" onclick="deleteModal.close()">إلغاء</button>
                <form id="deleteModalForm" method="POST">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-error btn-sm">نعم، احذف</button>
                </form>
            </div>
        </div>
        <form method="dialog" class="modal-backdrop"><button>إغلاق</button></form>
    </dialog>

    {{-- ══ Bulk Delete Modal ══ --}}
    <dialog id="bulkDeleteModal" class="modal">
        <div class="modal-box max-w-sm text-center" dir="rtl">
            <div class="flex items-center justify-center w-14 h-14 rounded-full bg-error/10 mx-auto mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-error" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
            </div>
            <h3 class="font-bold text-base mb-2">حذف المحددة</h3>
            <p class="text-sm text-base-content/60 mb-6" id="bulkDeleteText">
                هل أنت متأكد من حذف الماركات المحددة؟
            </p>
            <div class="flex gap-3 justify-center">
                <button class="btn btn-ghost btn-sm" onclick="bulkDeleteModal.close()">إلغاء</button>
                <form id="bulkDeleteForm" method="POST" action="{{ route('admin.brands.bulk-destroy') }}">
                    @csrf @method('DELETE')
                    <input type="hidden" name="ids" id="bulkDeleteIds">
                    <button type="submit" class="btn btn-error btn-sm">نعم، احذف الكل</button>
                </form>
            </div>
        </div>
        <form method="dialog" class="modal-backdrop"><button>إغلاق</button></form>
    </dialog>

    <script>
        // ── Delete Single ──
        function openDeleteModal(name, action) {
            document.getElementById('deleteModalText').textContent =
                'هل أنت متأكد من حذف ماركة "' + name + '"؟ هذا الإجراء لا يمكن التراجع عنه.';
            document.getElementById('deleteModalForm').action = action;
            deleteModal.showModal();
        }

        // ── Bulk Delete ──
        function openBulkDeleteModal() {
            const count = document.querySelectorAll('.brand-checkbox:checked').length;
            document.getElementById('bulkDeleteText').textContent =
                'هل أنت متأكد من حذف ' + count + ' ماركة؟ هذا الإجراء لا يمكن التراجع عنه.';
            document.getElementById('bulkDeleteIds').value = getSelectedIds();
            bulkDeleteModal.showModal();
        }

        // ── Toggle Confirm ──
        document.querySelectorAll('.toggle-form').forEach(function(form) {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                if (window.confirm('هل تريد ' + this.dataset.action + ' ماركة ' + this.dataset.name + '؟')) {
                    this.submit();
                }
            });
        });

        // ── Bulk Bar ──
        function getSelectedIds() {
            return [...document.querySelectorAll('.brand-checkbox:checked')]
                .map(cb => cb.value).join(',');
        }

        function updateBulkBar() {
            const count = document.querySelectorAll('.brand-checkbox:checked').length;
            const bar   = document.getElementById('bulkBar');
            if (count > 0) {
                bar.classList.remove('hidden');
                bar.classList.add('flex');
                document.getElementById('bulkCount').textContent  = count + ' محدد';
                const ids = getSelectedIds();
                document.getElementById('bulkActivateIds').value  = ids;
                document.getElementById('bulkHideIds').value      = ids;
            } else {
                bar.classList.add('hidden');
                bar.classList.remove('flex');
            }
        }

        function clearSelection() {
            document.querySelectorAll('.brand-checkbox').forEach(cb => cb.checked = false);
            updateBulkBar();
        }
    </script>

</x-layout>
