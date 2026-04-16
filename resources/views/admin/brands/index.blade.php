<x-layout>

<style>
.admin-page { max-width: 1400px; margin: 0 auto; padding: 32px; }
.page-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 28px; flex-wrap: wrap; gap: 12px; }
.page-title { font-size: 22px; font-weight: 700; color: var(--text); }
.page-subtitle { font-size: 13px; color: var(--text-muted); margin-top: 2px; }

.btn-primary {
    display: inline-flex; align-items: center; gap: 7px;
    background: var(--electric); color: #070810;
    padding: 9px 20px; border-radius: var(--radius-sm);
    font-weight: 800; font-size: 13px; font-family: 'Cairo', sans-serif;
    text-decoration: none; border: none; cursor: pointer;
    transition: all .2s;
}
.btn-primary:hover { transform: translateY(-1px); box-shadow: 0 6px 18px var(--electric-glow); }

.btn-ghost {
    display: inline-flex; align-items: center; gap: 6px;
    background: transparent; color: var(--text-soft);
    padding: 8px 14px; border-radius: var(--radius-sm);
    font-weight: 600; font-size: 13px; font-family: 'Cairo', sans-serif;
    text-decoration: none; border: 1px solid var(--border);
    cursor: pointer; transition: all .2s;
}
.btn-ghost:hover { border-color: var(--border-hover); color: var(--text); }

.btn-danger {
    display: inline-flex; align-items: center; gap: 6px;
    background: transparent; color: #fca5a5;
    padding: 8px 14px; border-radius: var(--radius-sm);
    font-weight: 600; font-size: 13px; font-family: 'Cairo', sans-serif;
    text-decoration: none; border: 1px solid rgba(239,68,68,.25);
    cursor: pointer; transition: all .2s;
}
.btn-danger:hover { background: rgba(239,68,68,.08); }

/* Search bar */
.search-box {
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: var(--radius-sm);
    padding: 20px;
    margin-bottom: 24px;
    display: flex; gap: 12px; flex-wrap: wrap;
}
.search-input {
    flex: 1; min-width: 200px;
    background: var(--surface2);
    border: 1px solid var(--border);
    border-radius: var(--radius-sm);
    padding: 10px 16px;
    color: var(--text); font-family: 'Cairo', sans-serif; font-size: 14px;
    outline: none; transition: border-color .2s;
}
.search-input:focus { border-color: var(--electric); }
.search-input::placeholder { color: var(--text-muted); }

.filter-select {
    background: var(--surface2);
    border: 1px solid var(--border);
    border-radius: var(--radius-sm);
    padding: 10px 16px;
    color: var(--text); font-family: 'Cairo', sans-serif; font-size: 14px;
    outline: none; cursor: pointer; transition: border-color .2s;
}
.filter-select:focus { border-color: var(--electric); }
.filter-select option { background: var(--surface2); }

/* Brands grid */
.brands-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
    gap: 16px;
}

.brand-card {
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: var(--radius);
    padding: 24px 16px 16px;
    display: flex; flex-direction: column; align-items: center; gap: 10px;
    transition: all .2s;
    position: relative;
    overflow: hidden;
}
.brand-card::before {
    content: '';
    position: absolute; top: 0; left: 0; right: 0; height: 2px;
    background: var(--electric);
    opacity: 0; transition: opacity .2s;
}
.brand-card:hover { border-color: var(--border-hover); transform: translateY(-2px); }
.brand-card:hover::before { opacity: 1; }

.brand-logo {
    width: 72px; height: 72px;
    background: var(--surface2);
    border: 1px solid var(--border);
    border-radius: var(--radius-sm);
    display: flex; align-items: center; justify-content: center;
    overflow: hidden;
}
.brand-logo img { width: 100%; height: 100%; object-fit: contain; }
.brand-logo-placeholder {
    font-size: 24px; font-weight: 900; color: var(--electric);
    font-family: 'Tajawal', sans-serif;
}

.brand-name {
    font-size: 15px; font-weight: 700; color: var(--text);
    text-align: center;
}
.brand-meta { font-size: 12px; color: var(--text-muted); }

.badge {
    display: inline-flex; align-items: center; gap: 4px;
    padding: 3px 10px; border-radius: 99px;
    font-size: 11px; font-weight: 700;
}
.badge-active { background: rgba(34,197,94,.1); color: #86efac; border: 1px solid rgba(34,197,94,.2); }
.badge-inactive { background: rgba(100,100,120,.1); color: var(--text-muted); border: 1px solid var(--border); }

.brand-actions {
    display: flex; gap: 6px; margin-top: 4px; width: 100%;
    justify-content: center; flex-wrap: wrap;
}
.brand-actions .btn-ghost, .brand-actions .btn-danger {
    padding: 6px 12px; font-size: 12px; flex: 1;
    justify-content: center;
}

/* Empty state */
.empty-state {
    grid-column: 1 / -1;
    display: flex; flex-direction: column; align-items: center;
    padding: 64px 0; color: var(--text-muted);
}
.empty-icon { font-size: 48px; margin-bottom: 16px; opacity: .4; }
.empty-text { font-size: 15px; font-weight: 600; color: var(--text-soft); }
.empty-sub { font-size: 13px; margin-top: 6px; }

/* Pagination */
.pagination-wrap { margin-top: 32px; display: flex; justify-content: center; }
.pagination-wrap nav { display: flex; gap: 6px; }
.pagination-wrap .page-link {
    background: var(--surface); border: 1px solid var(--border);
    color: var(--text-soft); border-radius: var(--radius-sm);
    padding: 8px 14px; font-size: 13px; font-weight: 600;
    text-decoration: none; transition: all .2s;
}
.pagination-wrap .page-link:hover { border-color: var(--electric); color: var(--electric); }
.pagination-wrap .page-item.active .page-link { background: var(--electric-dim); border-color: rgba(245,158,11,.3); color: var(--electric); }

@media (max-width: 768px) {
    .admin-page { padding: 20px 16px; }
    .brands-grid { grid-template-columns: repeat(auto-fill, minmax(150px, 1fr)); }
}
</style>

<div class="admin-page">

    {{-- Header --}}
    <div class="page-header">
        <div>
            <div class="page-title">الماركات</div>
            <div class="page-subtitle">إدارة ماركات الأدوات الكهربائية</div>
        </div>
        <a href="{{ route('admin.brands.create') }}" class="btn-primary">
            <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" d="M12 4v16m8-8H4"/></svg>
            إضافة ماركة
        </a>
    </div>

    {{-- Search --}}
    <form method="GET" action="{{ route('admin.brands.index') }}" class="search-box">
        <input type="text" name="search" class="search-input"
               placeholder="ابحث باسم الماركة..." value="{{ request('search') }}">
        <select name="status" class="filter-select">
            <option value="">كل الحالات</option>
            <option value="1" @selected(request('status') === '1')>نشط</option>
            <option value="0" @selected(request('status') === '0')>غير نشط</option>
        </select>
        <button type="submit" class="btn-primary">بحث</button>
        @if(request()->hasAny(['search','status']))
            <a href="{{ route('admin.brands.index') }}" class="btn-ghost">مسح</a>
        @endif
    </form>

    {{-- Grid --}}
    <div class="brands-grid">
        @forelse($brands as $brand)
        <div class="brand-card">

            <div class="brand-logo">
                @if($brand->logo)
                    <img src="{{ asset('storage/' . $brand->logo) }}" alt="{{ $brand->name }}">
                @else
                    <div class="brand-logo-placeholder">
                        {{ strtoupper(substr($brand->name, 0, 2)) }}
                    </div>
                @endif
            </div>

            <div class="brand-name">{{ $brand->name }}</div>
            <div class="brand-meta">{{ $brand->products_count }} منتج</div>

            <span class="badge {{ $brand->is_active ? 'badge-active' : 'badge-inactive' }}">
                <svg width="8" height="8" fill="currentColor" viewBox="0 0 8 8"><circle cx="4" cy="4" r="4"/></svg>
                {{ $brand->is_active ? 'نشط' : 'غير نشط' }}
            </span>

            <div class="brand-actions">
                <a href="{{ route('admin.brands.edit', $brand) }}" class="btn-ghost">
                    <svg width="12" height="12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                    تعديل
                </a>

                <form method="POST" action="{{ route('admin.brands.toggle-status', $brand) }}" style="flex:1;">
                    @csrf @method('PATCH')
                    <button type="submit" class="btn-ghost" style="width:100%;justify-content:center;">
                        {{ $brand->is_active ? 'إخفاء' : 'تفعيل' }}
                    </button>
                </form>
            </div>

            <form method="POST" action="{{ route('admin.brands.destroy', $brand) }}" style="width:100%;"
                  onsubmit="return confirm('هل أنت متأكد من حذف {{ $brand->name }}؟')">
                @csrf @method('DELETE')
                <button type="submit" class="btn-danger" style="width:100%;justify-content:center;">
                    <svg width="12" height="12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                    حذف
                </button>
            </form>

        </div>
        @empty
        <div class="empty-state">
            <div class="empty-icon">🏷️</div>
            <div class="empty-text">لا توجد ماركات</div>
            <div class="empty-sub">ابدأ بإضافة أول ماركة لمتجرك</div>
        </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    @if($brands->hasPages())
    <div class="pagination-wrap">
        {{ $brands->links() }}
    </div>
    @endif

</div>

</x-layout>
