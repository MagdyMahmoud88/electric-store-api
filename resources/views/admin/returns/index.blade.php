<x-layout>
    <div dir="rtl" class="p-6">

        {{-- Header --}}
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-2xl font-black">طلبات الإرجاع والضمان</h1>
                <p class="text-sm text-base-content/50 mt-1">راجع وقرر على طلبات العملاء</p>
            </div>
            {{-- Badge عدد الـ pending --}}
            @php $pendingCount = $returns->where('status', 'pending')->count(); @endphp
            @if($pendingCount > 0)
                <div class="badge badge-warning badge-lg font-black gap-1">
                    {{ $pendingCount }} في الانتظار
                </div>
            @endif
        </div>

        @if(session('success'))
            <div class="alert alert-success mb-4 text-sm">{{ session('success') }}</div>
        @endif

        {{-- فلاتر --}}
        <form method="GET" class="flex flex-wrap gap-3 mb-6">
            <select name="status" onchange="this.form.submit()" class="select select-bordered select-sm font-bold w-40">
                <option value="">كل الحالات</option>
                @foreach($statusLabels as $val => $label)
                    <option value="{{ $val }}" {{ request('status') === $val ? 'selected' : '' }}>{{ $label }}</option>
                @endforeach
            </select>

            <label class="input input-bordered input-sm flex items-center gap-2 flex-1 max-w-xs">
                <svg class="w-3.5 h-3.5 opacity-40" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <circle cx="11" cy="11" r="8"/><path stroke-linecap="round" d="M21 21l-4.35-4.35"/>
                </svg>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="اسم العميل أو رقم الطلب..." class="grow text-xs">
            </label>

            @if(request()->hasAny(['status', 'search']))
                <a href="{{ route('admin.returns.index') }}" class="btn btn-ghost btn-sm">مسح الفلاتر ✕</a>
            @endif
        </form>

        {{-- الجدول --}}
        <div class="card bg-base-100 border border-base-300 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="table table-sm">
                    <thead class="bg-base-200 text-xs font-black uppercase tracking-wider">
                    <tr>
                        <th>#</th>
                        <th>العميل</th>
                        <th>المنتج</th>
                        <th>السبب</th>
                        <th>الحالة</th>
                        <th>التاريخ</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($returns as $return)
                        <tr class="hover:bg-base-50 {{ $return->isPending() ? 'bg-warning/5' : '' }}">
                            <td class="font-mono text-xs text-base-content/40">{{ $return->id }}</td>
                            <td>
                                <p class="font-bold text-sm">{{ $return->user->name }}</p>
                                <p class="text-xs text-base-content/40">طلب #{{ $return->order_id }}</p>
                            </td>
                            <td>
                                <p class="text-sm font-medium max-w-[150px] truncate">{{ $return->product->name }}</p>
                            </td>
                            <td class="text-xs">{{ $return->reasonLabel() }}</td>
                            <td>
                                <div class="badge badge-{{ $return->statusColor() }} badge-sm font-bold">
                                    {{ $return->statusLabel() }}
                                </div>
                            </td>
                            <td class="text-xs text-base-content/50">{{ $return->created_at->format('d/m/Y') }}</td>
                            <td>
                                <a href="{{ route('admin.returns.show', $return) }}" class="btn btn-ghost btn-xs font-bold">
                                    عرض ←
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-10 text-base-content/30 text-sm">
                                لا توجد طلبات إرجاع
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Pagination --}}
        @if($returns->hasPages())
            <div class="flex justify-center mt-6">
                {{ $returns->withQueryString()->links() }}
            </div>
        @endif

    </div>
</x-layout>
