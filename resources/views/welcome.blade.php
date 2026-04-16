<x-layout>

<div class="font-cairo bg-base-100 text-base-content rtl overflow-x-hidden min-h-screen">
    <x-welcome.hero        :latestProducts="$latestProducts" />
    <x-welcome.ticker />
    <x-welcome.offers      :discountedProducts="$discountedProducts" />
    <x-welcome.latest-products :latestProducts="$latestProducts" />
    <x-welcome.features />
    <x-welcome.reviews />
    <x-welcome.categories  :categories="$categories" />
    <x-welcome.cta />

</div>

<script>
const observer = new IntersectionObserver(entries => {
    entries.forEach(e => {
        if (e.isIntersecting) { e.target.classList.add('visible'); observer.unobserve(e.target); }
    });
}, { threshold: 0.12 });
document.querySelectorAll('.reveal').forEach(el => observer.observe(el));

function animateCounter(el, target, duration = 1800) {
    let start = 0;
    const step = target / (duration / 16);
    const timer = setInterval(() => {
        start += step;
        if (start >= target) { el.textContent = '+' + target.toLocaleString(); clearInterval(timer); }
        else { el.textContent = '+' + Math.floor(start).toLocaleString(); }
    }, 16);
}
const counterObs = new IntersectionObserver(entries => {
    entries.forEach(e => {
        if (e.isIntersecting) {
            animateCounter(e.target, parseInt(e.target.dataset.target));
            counterObs.unobserve(e.target);
        }
    });
}, { threshold: 0.5 });
document.querySelectorAll('[data-target]').forEach(el => counterObs.observe(el));
</script>

</x-layout>
