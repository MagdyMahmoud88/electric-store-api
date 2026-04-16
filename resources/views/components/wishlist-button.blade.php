
@auth
    @php
        $inWishlist = auth()->user()->hasInWishlist($product->id);
    @endphp

    <button
        class="wishlist-btn {{ $inWishlist ? 'active' : '' }}"
        data-product-id="{{ $product->id }}"
        data-toggle-url="{{ route('wishlist.toggle', $product->id) }}"
        title="{{ $inWishlist ? 'إزالة من المفضلة' : 'أضف للمفضلة' }}" >
        <i class="fa-{{ $inWishlist ? 'solid' : 'regular' }} fa-bookmark {{ $inWishlist ? 'text-error' : '' }}"></i>
    </button>

@else
    <a href="{{ route('login.index') }}"
       class="wishlist-btn"
       title="سجل دخول لإضافة للمفضلة">
        <i class="fa-regular fa-bookmark"></i>
    </a>
@endauth


@once
@push('scripts')
<script>
document.addEventListener('click', function (e) {
    const btn = e.target.closest('.wishlist-btn');
    if (!btn || btn.tagName === 'A') return;

    const url  = btn.dataset.toggleUrl;
    const icon = btn.querySelector('i');

    btn.disabled = true;

    fetch(url, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept':       'application/json',
            'Content-Type': 'application/json',
        },
    })
    .then(r => r.json())
    .then(data => {
        if (data.in_wishlist) {
            icon.classList.replace('fa-regular', 'fa-solid');
            icon.classList.add('text-error');
            btn.classList.add('active');
            btn.title = 'إزالة من المفضلة';
        } else {
            icon.classList.replace('fa-solid', 'fa-regular');
            icon.classList.remove('text-error');
            btn.classList.remove('active');
            btn.title = 'أضف للمفضلة';
        }

        const counter = document.getElementById('wishlist-count');
        if (counter) {
            counter.textContent = data.count;
                counter.style.display = data.count > 0 ? 'flex' : 'none';

        }

    })
    .catch(() => alert('حصل خطأ، حاول تاني'))
    .finally(() => btn.disabled = false);
});
</script>
@endpush
@endonce
