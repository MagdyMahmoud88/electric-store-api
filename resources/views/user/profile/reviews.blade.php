<x-layout>
    <x-slot name="title">تقييماتي</x-slot>

    <div class="min-h-screen bg-base-300 py-10 px-4">
        {{-- ── Header Section ── --}}
        <div class="max-w-2xl mx-auto text-center mb-10">
            <h1 class="text-3xl font-black text-primary mb-2 family-cairo">تقييماتي الشخصية</h1>
            <p class="text-base-content/70">إجمالي التقييمات: <span class="badge badge-secondary badge-outline">{{ $reviews->total() }}</span></p>

            <div class="mt-4">
                <a href="{{ route('profile.index') }}" class="btn btn-ghost btn-sm gap-2">
                    <i class="fa fa-arrow-right"></i>
                    العودة للملف الشخصي
                </a>
            </div>
        </div>

        {{-- ── Main Content ── --}}
        <div class="max-w-2xl mx-auto space-y-6">
            @forelse($reviews as $review)
                <div class="card bg-base-100 shadow-xl border border-base-content/10">
                    <div class="card-body items-center text-center">
                        {{-- اسم المنتج --}}
                        <h2 class="card-title text-xl font-bold text-secondary">{{ $review->product->name }}</h2>

                        {{-- النجوم (DaisyUI Rating) --}}
                        <div class="rating rating-sm rating-half pointer-events-none my-2">
                            @for($i = 1; $i <= 5; $i++)
                                <input type="radio" class="mask mask-star-2 bg-orange-400" @checked($i == $review->rating) />
                            @endfor
                        </div>

                        {{-- تاريخ التقييم --}}
                        <div class="text-xs text-base-content/50 mb-4">
                            {{ $review->created_at->diffForHumans() }}
                        </div>

                        {{-- نص التقييم --}}
                        <div class="bg-base-200 p-4 rounded-xl w-full">
                            <p class="italic">"{{ $review->comment }}"</p>
                        </div>

                        {{-- الأكشن --}}
                        <div class="card-actions justify-end w-full mt-4">
                            <a href="{{ route('products.show', $review->product->id) }}" class="btn btn-primary btn-sm btn-outline rounded-full px-6">
                                عرض المنتج
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                {{-- Empty State باستخدام DaisyUI Hero --}}
                <div class="hero bg-base-100 rounded-3xl py-16 border-2 border-dashed border-base-content/10">
                    <div class="hero-content text-center">
                        <div class="max-w-md">
                            <div class="mb-5 text-5xl">💬</div>
                            <h1 class="text-2xl font-bold italic opacity-50">لا توجد تقييمات حتى الآن</h1>
                            <p class="py-6 text-base-content/60 font-semibold">بإمكانك البدء بتقييم المنتجات التي قمت بشرائها.</p>
                            <a href="/" class="btn btn-primary px-10 rounded-full shadow-lg shadow-primary/20">ابدأ التسوق</a>
                        </div>
                    </div>
                </div>
            @endforelse

            {{-- الترقيم (Pagination) --}}
            <div class="flex justify-center mt-8">
                <div class="join">
                    {{ $reviews->links() }}
                </div>
            </div>
        </div>
    </div>

    @push('styles')
    <style>
        .family-cairo { font-family: 'Cairo', sans-serif; }
    </style>
    @endpush
</x-layout>
