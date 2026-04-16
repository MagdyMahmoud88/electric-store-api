<x-layout>
    <x-slot name="title">إدارة التقييمات</x-slot>

    <div dir="rtl" class="min-h-screen bg-base-200">
        <div class="container mx-auto px-4 py-8">

            {{-- ══ HEADER ══ --}}
            <div class="flex items-center justify-between flex-wrap gap-3 mb-6">
                <div>
                    <h1 class="text-2xl font-black" style="font-family:'Cairo',sans-serif;">
                        <i class="fa-solid fa-star text-warning me-2"></i>
                        إدارة التقييمات
                    </h1>
                    <p class="text-base-content/50 text-sm mt-1">مراجعة واعتماد تقييمات العملاء</p>
                </div>
                <div class="flex gap-2 flex-wrap">
                    <span class="badge badge-warning badge-lg font-bold py-3 w-24">
                        {{ $reviews->total() }} إجمالي
                    </span>
                    <span class="badge badge-success badge-lg font-bold py-3 w-24">
                        {{ $reviews->where('is_approved', true)->count() }} معتمد
                    </span>
                    <span class="badge badge-error badge-lg font-bold py-3 w-24">
                        {{ $reviews->where('is_approved', false)->count() }} انتظار
                    </span>
                </div>
            </div>

            {{-- ══ TABLE ══ --}}
            <div class="card bg-base-100 border border-base-300 shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="table table-zebra text-sm w-full">
                        <thead class="bg-base-200">
                            <tr class="text-xs font-black text-base-content/50">
                                <th>#</th>
                                <th>المنتج</th>
                                <th>المستخدم</th>
                                <th>التقييم</th>
                                <th>التعليق</th>
                                <th>الحالة</th>
                                <th>التاريخ</th>
                                <th>إجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($reviews as $review)
                                <tr class="hover">

                                    <td class="text-base-content/40 text-xs">{{ $review->id }}</td>

                                    {{-- المنتج --}}
                                    <td>
                                        <div class="flex items-center gap-2">
                                            @if($review->product->image_url)
                                                <img src="{{ Storage::url($review->product->image_url) }}"
                                                     class="w-8 h-8 rounded object-contain bg-white flex-shrink-0"
                                                     onerror="this.src='{{ asset('images/placeholder.png') }}'">
                                            @endif
                                            <a href="{{ route('products.show', $review->product_id) }}"
                                               class="font-bold text-xs max-w-[130px] truncate hover:text-warning transition-colors">
                                                {{ $review->product->name }}
                                            </a>
                                        </div>
                                    </td>

                                    {{-- المستخدم --}}
                                    <td>
                                        <div class="flex items-center gap-2">
                                            <div class="w-7 h-7 rounded-full bg-warning/20 flex items-center justify-center
                                                        font-black text-warning text-xs flex-shrink-0">
                                                {{ strtoupper(substr($review->user->name, 0, 1)) }}
                                            </div>
                                            <div>
                                                <p class="text-xs font-bold">{{ $review->user->name }}</p>
                                                <p class="text-[10px] text-base-content/40">{{ $review->user->email }}</p>
                                            </div>
                                        </div>
                                    </td>

                                    {{-- التقييم --}}
                                    <td>
                                        <div class="flex gap-0.5 items-center">
                                            @for($i = 1; $i <= 5; $i++)
                                                <svg class="w-3.5 h-3.5 {{ $i <= $review->rating ? 'text-warning' : 'text-base-300' }}"
                                                     fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                                </svg>
                                            @endfor
                                            <span class="text-xs font-bold text-base-content/50 mr-1">{{ $review->rating }}/5</span>
                                        </div>
                                    </td>

                                    {{-- التعليق --}}
                                    <td class="max-w-[180px]">
                                        @if($review->comment)
                                            <p class="text-xs text-base-content/70 truncate" title="{{ $review->comment }}">
                                                {{ $review->comment }}
                                            </p>
                                        @else
                                            <span class="text-base-content/30 text-xs">—</span>
                                        @endif
                                    </td>

                                    {{-- الحالة --}}
                                    <td>
                                        @if($review->is_approved)
                                            <span class="badge badge-success badge-sm gap-1 font-bold w-24">
                                                <i class="fa-solid fa-circle-check fa-xs"></i> معتمد
                                            </span>
                                        @else
                                            <span class="badge badge-warning badge-sm gap-1 font-bold animate-pulse w-24">
                                                <i class="fa-solid fa-clock fa-xs"></i> انتظار
                                            </span>
                                        @endif
                                    </td>

                                    {{-- التاريخ --}}
                                    <td class="text-xs text-base-content/40 whitespace-nowrap">
                                        {{ $review->created_at->format('Y/m/d') }}<br>
                                        <span class="text-[10px]">{{ $review->created_at->diffForHumans() }}</span>
                                    </td>

                                    {{-- الإجراءات --}}
                                    <td>
                                        <div class="flex gap-1">
                                            @if(!$review->is_approved)
                                                <form action="{{ route('admin.reviews.approve', $review) }}" method="POST">
                                                    @csrf @method('PATCH')
                                                    <button class="btn btn-xs btn-success gap-1 font-bold" title="اعتماد">
                                                        <i class="fa-solid fa-check fa-xs"></i>
                                                        اعتماد
                                                    </button>
                                                </form>
                                            @else
                                                <form action="{{ route('admin.reviews.reject', $review) }}" method="POST">
                                                    @csrf @method('PATCH')
                                                    <button class="btn btn-xs btn-warning gap-1 font-bold" title="إخفاء">
                                                        <i class="fa-solid fa-eye-slash fa-xs"></i>
                                                        إخفاء
                                                    </button>
                                                </form>
                                            @endif

                                            <form action="{{ route('admin.reviews.destroy', $review) }}" method="POST"
                                                  onsubmit="return confirm('هتحذف التقييم ده؟')">
                                                @csrf @method('DELETE')
                                                <button class="btn btn-xs btn-error" title="حذف">
                                                    <i class="fa-solid fa-trash fa-xs"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>

                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8">
                                        <div class="flex flex-col items-center justify-center py-16 gap-3">
                                            <i class="fa-regular fa-star text-4xl text-base-content/20"></i>
                                            <p class="font-bold text-base-content/40">لا توجد تقييمات بعد</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($reviews->hasPages())
                    <div class="p-4 border-t border-base-300 flex justify-center">
                        {{ $reviews->links() }}
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-layout>
