<x-layout>

<div class="page-container py-8" dir="rtl" style="font-family:'Cairo',sans-serif;">

    {{-- ── Header ── --}}
    <div class="flex items-center justify-between mb-8 flex-wrap gap-4">
        <div>
            <div class="flex items-center gap-2 mb-1 text-xs" style="color:var(--text-muted);">
                <a href="{{ route('admin.dashboard') }}"
                   style="color:var(--text-muted);text-decoration:none;"
                   onmouseover="this.style.color='var(--electric)'"
                   onmouseout="this.style.color='var(--text-muted)'">لوحة التحكم</a>
                <span>/</span>
                <span style="color:var(--text-soft);">الأقسام</span>
            </div>
            <h1 class="text-2xl font-black" style="color:var(--text);">إدارة الأقسام</h1>
        </div>
        <button onclick="document.getElementById('addModal').showModal()"
                class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl font-black text-sm transition-all duration-200 hover:-translate-y-0.5"
                style="background:var(--electric);color:#070810;border:none;cursor:pointer;"
                onmouseover="this.style.boxShadow='0 8px 24px var(--electric-glow)'"
                onmouseout="this.style.boxShadow='none'">
            <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" d="M12 4v16m8-8H4"/>
            </svg>
            إضافة قسم
        </button>
    </div>

    {{-- Flash --}}
    @if(session('success'))
    <div role="alert" class="alert alert-success mb-6 text-sm font-bold">
        <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-5 w-5" fill="none" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        {{ session('success') }}
    </div>
    @endif
    @if(session('error'))
    <div role="alert" class="alert alert-error mb-6 text-sm font-bold">
        <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-5 w-5" fill="none" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        {{ session('error') }}
    </div>
    @endif

    {{-- ── Stats ── --}}
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 mb-8">
        @foreach([
            ['إجمالي الأقسام', $stats['total'],    'var(--electric)',  'var(--electric-dim)',         'rgba(245,158,11,.25)'],
            ['أقسام نشطة',     $stats['active'],   '#22c55e',         'rgba(34,197,94,.1)',           'rgba(34,197,94,.25)'],
            ['أقسام معطلة',    $stats['inactive'], '#eab308',         'rgba(234,179,8,.1)',           'rgba(234,179,8,.25)'],
            ['إجمالي المنتجات',$stats['products'], '#3b82f6',         'rgba(59,130,246,.1)',          'rgba(59,130,246,.25)'],
        ] as [$label, $val, $color, $bg, $border])
        <div class="rounded-2xl p-4 transition-all duration-200 hover:-translate-y-1"
             style="background:var(--surface);border:1px solid var(--border);">
            <p class="text-2xl font-black mb-1" style="color:{{ $color }};">{{ $val }}</p>
            <p class="text-xs" style="color:var(--text-muted);">{{ $label }}</p>
        </div>
        @endforeach
    </div>

    {{-- ── Search & Filter ── --}}
    <form method="GET" action="{{ route('admin.categories.index') }}"
          class="flex gap-3 mb-6 flex-wrap">

        <label class="input input-bordered input-sm flex items-center gap-2 flex-1 min-w-48"
               style="background:var(--surface);border-color:var(--border);color:var(--text);">
            <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"
                 style="color:var(--text-muted);">
                <circle cx="11" cy="11" r="8"/><path stroke-linecap="round" d="M21 21l-4.35-4.35"/>
            </svg>
            <input type="text" name="search" value="{{ request('search') }}"
                   placeholder="ابحث عن قسم..."
                   class="grow bg-transparent outline-none text-sm" style="color:var(--text);">
        </label>

        <select name="status" onchange="this.form.submit()"
                class="select select-bordered select-sm"
                style="background:var(--surface);border-color:var(--border);color:var(--text);">
            <option value="">كل الحالات</option>
            <option value="active"   {{ request('status') == 'active'   ? 'selected' : '' }}>نشط</option>
            <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>معطل</option>
        </select>

        <button type="submit"
                class="btn btn-sm font-black"
                style="background:var(--electric);color:#070810;border:none;">
            بحث
        </button>

        @if(request()->hasAny(['search','status']))
        <a href="{{ route('admin.categories.index') }}"
           class="btn btn-sm btn-ghost font-bold"
           style="border:1px solid var(--border);color:var(--text-soft);">
            مسح
        </a>
        @endif
    </form>

    {{-- ── Categories Grid ── --}}
    @if($categories->isEmpty())
        <div class="flex flex-col items-center justify-center py-20 gap-4">
            <div class="w-20 h-20 rounded-2xl flex items-center justify-center text-4xl"
                 style="background:var(--surface);border:1px solid var(--border);">📦</div>
            <p class="text-sm font-bold" style="color:var(--text-muted);">لا توجد أقسام حتى الآن</p>
            <button onclick="document.getElementById('addModal').showModal()"
                    class="btn btn-sm font-black"
                    style="background:var(--electric);color:#070810;border:none;">
                إضافة أول قسم
            </button>
        </div>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
            @foreach($categories as $cat)
            <div class="rounded-2xl p-5 flex flex-col gap-3 transition-all duration-200 hover:-translate-y-1"
                 style="background:var(--surface);border:1px solid var(--border);"
                 onmouseover="this.style.borderColor='rgba(245,158,11,.3)'"
                 onmouseout="this.style.borderColor='var(--border)'">

                {{-- Top row --}}
                <div class="flex items-start justify-between">
                    <div class="w-12 h-12 rounded-xl flex items-center justify-center text-2xl"
                         style="background:var(--electric-dim);border:1px solid rgba(245,158,11,.2);">
                        {{ $cat->icon ?? '⚡' }}
                    </div>
                    <div class="flex items-center gap-1">
                        <button onclick="openEdit({{ $cat->id }}, '{{ addslashes($cat->name) }}', '{{ addslashes($cat->description ?? '') }}', '{{ $cat->icon }}', '{{ $cat->color }}', '{{ $cat->status }}')"
                                class="btn btn-xs btn-ghost"
                                style="color:var(--text-muted);">
                            <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                        </button>
                        <button onclick="openDelete({{ $cat->id }}, '{{ addslashes($cat->name) }}')"
                                class="btn btn-xs btn-ghost"
                                style="color:#fca5a5;">
                            <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                        </button>
                    </div>
                </div>

                {{-- Name & desc --}}
                <div class="flex-1">
                    <h2 class="font-black text-sm mb-1" style="color:var(--text);">{{ $cat->name }}</h2>
                    <p class="text-xs leading-relaxed" style="color:var(--text-muted);">
                        {{ $cat->description ?? 'لا يوجد وصف' }}
                    </p>
                </div>

                {{-- Footer --}}
                <div class="flex items-center justify-between pt-3"
                     style="border-top:1px solid var(--border);">
                    <span class="text-xs font-bold" style="color:var(--text-muted);">
                        <span style="color:var(--text);">{{ $cat->products_count }}</span> منتج
                    </span>

                    {{-- Toggle status form --}}
                    <form action="{{ route('admin.categories.toggleStatus', $cat) }}" method="POST">
                        @csrf @method('PATCH')
                        <button type="submit"
                                class="badge badge-sm font-bold cursor-pointer border-0 transition-all"
                                style="background:{{ $cat->status === 'active' ? 'rgba(34,197,94,.15)' : 'rgba(107,114,128,.15)' }};
                                       color:{{ $cat->status === 'active' ? '#86efac' : 'var(--text-muted)' }};">
                            {{ $cat->status === 'active' ? 'نشط' : 'معطل' }}
                        </button>
                    </form>
                </div>

            </div>
            @endforeach
        </div>
    @endif

</div>


{{-- ══ Add / Edit Modal ══ --}}
<dialog id="addModal" class="modal">
    <div class="modal-box max-w-lg rounded-2xl p-8"
         style="background:var(--surface);border:1px solid var(--border);">

        <h3 class="font-black text-lg mb-6" id="modalTitle" style="color:var(--text);">إضافة قسم جديد</h3>

        <form id="categoryForm" method="POST" class="space-y-4">
            @csrf
            <div id="methodField"></div>

            {{-- Name --}}
            <div class="form-control gap-1.5">
                <label class="label py-0">
                    <span class="label-text text-xs font-bold" style="color:var(--text-soft);">
                        اسم القسم <span style="color:var(--electric);">*</span>
                    </span>
                </label>
                <input type="text" name="name" id="fName"
                       placeholder="مثال: أسلاك كهربائية"
                       class="input input-bordered w-full"
                       style="background:var(--surface2);border-color:var(--border);color:var(--text);"
                       required>
            </div>

            {{-- Description --}}
            <div class="form-control gap-1.5">
                <label class="label py-0">
                    <span class="label-text text-xs font-bold" style="color:var(--text-soft);">الوصف</span>
                </label>
                <textarea name="description" id="fDesc" rows="3"
                          placeholder="وصف مختصر..."
                          class="textarea textarea-bordered w-full leading-relaxed"
                          style="background:var(--surface2);border-color:var(--border);color:var(--text);resize:vertical;"></textarea>
            </div>

            {{-- Color + Status --}}
            <div class="grid grid-cols-2 gap-3">
                <div class="form-control gap-1.5">
                    <label class="label py-0">
                        <span class="label-text text-xs font-bold" style="color:var(--text-soft);">اللون</span>
                    </label>
                    <select name="color" id="fColor"
                            class="select select-bordered w-full"
                            style="background:var(--surface2);border-color:var(--border);color:var(--text);">
                        <option value="icon-blue">أزرق</option>
                        <option value="icon-amber">ذهبي</option>
                        <option value="icon-teal">أخضر فاتح</option>
                        <option value="icon-coral">برتقالي</option>
                        <option value="icon-purple">بنفسجي</option>
                        <option value="icon-green">أخضر</option>
                    </select>
                </div>
                <div class="form-control gap-1.5">
                    <label class="label py-0">
                        <span class="label-text text-xs font-bold" style="color:var(--text-soft);">الحالة</span>
                    </label>
                    <select name="status" id="fStatus"
                            class="select select-bordered w-full"
                            style="background:var(--surface2);border-color:var(--border);color:var(--text);">
                        <option value="active">نشط</option>
                        <option value="inactive">معطل</option>
                    </select>
                </div>
            </div>

            {{-- Icon --}}
            <div class="form-control gap-1.5">
                <label class="label py-0">
                    <span class="label-text text-xs font-bold" style="color:var(--text-soft);">الأيقونة (emoji)</span>
                </label>
                <input type="text" name="icon" id="fIcon"
                       placeholder="مثال: ⚡"
                       class="input input-bordered w-full"
                       style="background:var(--surface2);border-color:var(--border);color:var(--text);"
                       maxlength="4">
            </div>

            {{-- Actions --}}
            <div class="flex items-center justify-end gap-3 pt-2">
                <button type="button"
                        onclick="document.getElementById('addModal').close()"
                        class="btn btn-sm btn-ghost font-bold"
                        style="border:1px solid var(--border);color:var(--text-soft);">
                    إلغاء
                </button>
                <button type="submit"
                        class="btn btn-sm font-black"
                        style="background:var(--electric);color:#070810;border:none;">
                    <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" d="M5 13l4 4L19 7"/>
                    </svg>
                    حفظ
                </button>
            </div>
        </form>
    </div>
    <form method="dialog" class="modal-backdrop"><button>close</button></form>
</dialog>


{{-- ══ Delete Modal ══ --}}
<dialog id="deleteModal" class="modal">
    <div class="modal-box max-w-sm rounded-2xl p-8 text-center"
         style="background:var(--surface);border:1px solid rgba(239,68,68,.25);">

        <div class="w-16 h-16 rounded-2xl flex items-center justify-center mx-auto mb-4"
             style="background:rgba(239,68,68,.1);border:1px solid rgba(239,68,68,.25);">
            <svg width="28" height="28" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"
                 style="color:#ef4444;">
                <path stroke-linecap="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
            </svg>
        </div>

        <h3 class="font-black text-base mb-2" style="color:var(--text);">حذف القسم</h3>
        <p class="text-sm mb-6" style="color:var(--text-muted);">
            هتحذف <strong id="delName" style="color:var(--text);"></strong>؟
            <br>هذا الإجراء لا يمكن التراجع عنه.
        </p>

        <form id="deleteForm" method="POST">
            @csrf @method('DELETE')
            <div class="flex items-center justify-center gap-3">
                <button type="button"
                        onclick="document.getElementById('deleteModal').close()"
                        class="btn btn-sm btn-ghost font-bold"
                        style="border:1px solid var(--border);color:var(--text-soft);">
                    إلغاء
                </button>
                <button type="submit" class="btn btn-sm btn-error font-black gap-1.5">
                    <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                    حذف
                </button>
            </div>
        </form>
    </div>
    <form method="dialog" class="modal-backdrop"><button>close</button></form>
</dialog>


<style>
    .input:focus, .select:focus, .textarea:focus {
        border-color: var(--electric) !important;
        box-shadow: 0 0 0 3px var(--electric-glow) !important;
        outline: none;
    }
    .modal-box { color: var(--text); }
</style>

<script>
function openEdit(id, name, desc, icon, color, status) {
    document.getElementById('modalTitle').textContent = 'تعديل القسم';
    document.getElementById('methodField').innerHTML = '<input type="hidden" name="_method" value="PUT">';
    document.getElementById('categoryForm').action = '/admin/categories/' + id;
    document.getElementById('fName').value   = name;
    document.getElementById('fDesc').value   = desc;
    document.getElementById('fIcon').value   = icon;
    document.getElementById('fColor').value  = color;
    document.getElementById('fStatus').value = status;
    document.getElementById('addModal').showModal();
}

function openDelete(id, name) {
    document.getElementById('delName').textContent  = name;
    document.getElementById('deleteForm').action    = '/admin/categories/' + id;
    document.getElementById('deleteModal').showModal();
}

document.getElementById('addModal').addEventListener('close', function () {
    document.getElementById('modalTitle').textContent = 'إضافة قسم جديد';
    document.getElementById('methodField').innerHTML  = '';
    document.getElementById('categoryForm').action    = "{{ route('admin.categories.store') }}";
    document.getElementById('categoryForm').reset();
});
</script>

</x-layout>
