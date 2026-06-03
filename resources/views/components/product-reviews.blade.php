{{--
    resources/views/components/product-reviews.blade.php
    الاستخدام: <x-product-reviews :product="$product" />
--}}

@php
    $reviews     = $product->approvedReviews()->with('user')->latest()->get();
    $avgRating   = $product->average_rating;
    $totalCount  = $product->ratings_count;
    $userReview  = auth()->check() ? $product->reviews()->where('user_id', auth()->id())->first() : null;
    $canReview   = auth()->check() && !$userReview;

    $distribution = [];
    for ($i = 5; $i >= 1; $i--) {
        $count = $product->approvedReviews()->where('rating', $i)->count();
        $distribution[$i] = [
            'count'   => $count,
            'percent' => $totalCount > 0 ? round(($count / $totalCount) * 100) : 0,
        ];
    }
@endphp

<div class="mt-10" id="reviews-section">

    {{-- ══ HEADER ══ --}}
    <div class="flex items-center gap-3 mb-6 pb-4 border-b border-base-300">
        <h2 class="text-xl font-black" style="font-family:'Cairo',sans-serif;">
            التقييمات والمراجعات
        </h2>
        @if($totalCount > 0)
            <span class="badge badge-warning font-bold">{{ $totalCount }} تقييم</span>
        @endif
    </div>

    @if($totalCount > 0)
    {{-- ══ SUMMARY ══ --}}
    <div class="flex flex-col sm:flex-row gap-6 mb-8 p-5 bg-base-200 rounded-2xl">
        <div class="flex flex-col items-center justify-center flex-shrink-0 min-w-[120px]">
            <span class="text-5xl font-black text-warning">{{ $avgRating }}</span>
            <div class="flex gap-0.5 my-1">
                @for($i = 1; $i <= 5; $i++)
                    <svg class="w-5 h-5 {{ $i <= round($avgRating) ? 'text-warning' : 'text-base-300' }}"
                         fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                    </svg>
                @endfor
            </div>
            <span class="text-xs text-base-content/50">من 5</span>
        </div>

        <div class="flex flex-col gap-1.5 flex-1 justify-center">
            @foreach($distribution as $star => $data)
                <div class="flex items-center gap-2">
                    <span class="text-xs font-bold w-3 text-base-content/60">{{ $star }}</span>
                    <svg class="w-3.5 h-3.5 text-warning flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                    </svg>
                    <div class="flex-1 bg-base-300 rounded-full h-2 overflow-hidden">
                        <div class="bg-warning h-2 rounded-full transition-all duration-500"
                             style="width: {{ $data['percent'] }}%"></div>
                    </div>
                    <span class="text-xs text-base-content/50 w-8 text-left">{{ $data['count'] }}</span>
                </div>
            @endforeach
        </div>
    </div>
    @endif

    {{-- ══ FORM ══ --}}
    @auth
        @if($canReview)
        <div class="card bg-base-100 border border-base-300 mb-8">
            <div class="card-body p-5">
                <h3 class="font-black text-base mb-4" style="font-family:'Cairo',sans-serif;">أضف تقييمك</h3>
                <form action="{{ route('product.reviews.store', $product->id) }}" method="POST">
                    @csrf

                    {{-- النجوم --}}
                    <div class="mb-4">
                        <div class="flex items-center gap-1" id="star-container" dir="rtl">
                            @for($i = 5; $i >= 1; $i--)
                                <input type="radio" name="rating" value="{{ $i }}"
                                       id="star{{ $i }}" class="hidden"
                                       {{ old('rating') == $i ? 'checked' : '' }}>
                                <label for="star{{ $i }}"
                                       class="star-label cursor-pointer text-3xl transition-colors select-none"
                                       data-value="{{ $i }}"
                                       style="color: {{ old('rating') >= $i ? 'oklch(var(--wa))' : 'oklch(var(--bc) / 0.2)' }}">
                                    ★
                                </label>
                            @endfor
                            <span class="text-sm text-base-content/50 mr-2" id="star-text">
                                {{ old('rating') ? ['','سيء','مقبول','جيد','جيد جداً','ممتاز'][old('rating')] : 'اختر تقييمك' }}
                            </span>
                        </div>
                    </div>

                    @error('rating')
                        <p class="text-error text-xs mb-3">{{ $message }}</p>
                    @enderror

                    <textarea name="comment" rows="3"
                              placeholder="شاركنا رأيك في المنتج... (اختياري)"
                              class="textarea textarea-bordered w-full text-sm resize-none"
                              maxlength="1000">{{ old('comment') }}</textarea>
                    @error('comment')
                        <p class="text-error text-xs mt-1">{{ $message }}</p>
                    @enderror

                    <div class="flex justify-end mt-3">
                        <button type="submit" class="btn btn-warning btn-sm font-black gap-2">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                            </svg>
                            إرسال التقييم
                        </button>
                    </div>
                </form>
            </div>
        </div>

        @elseif($userReview)
        <div class="card bg-warning/10 border border-warning/30 mb-8">
            <div class="card-body p-4">
                <div class="flex items-center justify-between flex-wrap gap-3">
                    <div>
                        <p class="text-sm font-bold mb-1">تقييمك للمنتج</p>
                        <div class="flex gap-0.5">
                            @for($i = 1; $i <= 5; $i++)
                                <svg class="w-4 h-4 {{ $i <= $userReview->rating ? 'text-warning' : 'text-base-300' }}"
                                     fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                            @endfor
                        </div>
                        @if($userReview->comment)
                            <p class="text-sm text-base-content/70 mt-1">{{ $userReview->comment }}</p>
                        @endif
                        @if(!$userReview->is_approved)
                            <span class="badge badge-warning badge-sm mt-1">في انتظار المراجعة</span>
                        @endif
                    </div>
                    <form action="{{ route('product.reviews.destroy', $product->id) }}" method="POST">
                        @csrf @method('DELETE')
                        <button type="submit"
                                class="btn btn-ghost btn-sm text-error hover:bg-error/10"
                                onclick="return confirm('هتحذف تقييمك؟')">
                            <i class="fa-solid fa-trash fa-sm"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @endif

    @else
        <div class="alert mb-6 bg-base-200 border border-base-300">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <span class="text-sm">
                <a href="{{ route('login') }}" class="text-warning font-bold hover:underline">سجل دخول</a>
                لإضافة تقييمك
            </span>
        </div>
    @endauth

    {{-- ══ REVIEWS LIST ══ --}}
    @if($reviews->isEmpty())
        <div class="text-center py-10 text-base-content/40">
            <svg class="w-10 h-10 mx-auto mb-3 opacity-30" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                <path stroke-linecap="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
            </svg>
            <p class="text-sm">لا توجد تقييمات بعد — كن أول من يقيّم!</p>
        </div>
    @else
        <div class="flex flex-col gap-4">
            @foreach($reviews as $review)
                <div class="flex gap-3 pb-4 border-b border-base-200 last:border-0">
                    <div class="w-9 h-9 rounded-full bg-warning/20 flex items-center justify-center
                                flex-shrink-0 font-black text-warning text-sm">
                        {{ strtoupper(substr($review->user->name, 0, 1)) }}
                    </div>
                    <div class="flex-1">
                        <div class="flex items-center justify-between flex-wrap gap-1 mb-1">
                            <span class="font-bold text-sm">{{ $review->user->name }}</span>
                            <span class="text-xs text-base-content/40">{{ $review->created_at->diffForHumans() }}</span>
                        </div>
                        <div class="flex gap-0.5 mb-1">
                            @for($i = 1; $i <= 5; $i++)
                                <svg class="w-3.5 h-3.5 {{ $i <= $review->rating ? 'text-warning' : 'text-base-300' }}"
                                     fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                            @endfor
                        </div>
                        @if($review->comment)
                            <p class="text-sm text-base-content/75 leading-relaxed">{{ $review->comment }}</p>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    @endif

</div>

@once
@push('scripts')
<script>
(function () {
    const texts   = ['', 'سيء', 'مقبول', 'جيد', 'جيد جداً', 'ممتاز'];
    const labels  = document.querySelectorAll('#star-container .star-label');
    const starText = document.getElementById('star-text');

    if (!labels.length) return;

    const colorOn  = 'oklch(var(--wa))';
    const colorOff = 'oklch(var(--bc) / 0.2)';

    function paint(upTo) {
        labels.forEach(l => {
            l.style.color = parseInt(l.dataset.value) <= upTo ? colorOn : colorOff;
        });
    }

    function currentSelected() {
        const checked = document.querySelector('#star-container input[name="rating"]:checked');
        return checked ? parseInt(checked.value) : 0;
    }

    labels.forEach(label => {
        label.addEventListener('mouseenter', () => paint(parseInt(label.dataset.value)));
        label.addEventListener('mouseleave', () => paint(currentSelected()));
        label.addEventListener('click', () => {
            const val = parseInt(label.dataset.value);
            paint(val);
            if (starText) starText.textContent = texts[val] || '';
        });
    });
})();
</script>
@endpush
@endonce
