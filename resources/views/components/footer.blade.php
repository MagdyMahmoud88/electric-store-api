{{-- ── مسافة قبل الـ Footer (أضفها على آخر section فوق الـ footer) ── --}}
{{-- مثال: <section class="pb-20"> ... </section> --}}

{{-- ── FOOTER ── --}}
<footer class="bg-base-200 border-t border-white/10 pt-14 mt-20">
    <div class="max-w-7xl mx-auto px-6">

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10 pb-12">

            {{-- Brand --}}
            <div class="lg:col-span-1">
                <a href="{{ route('welcome') }}" class="flex items-center gap-2 mb-4 no-underline">
                    <span class="text-2xl">⚡</span>
                    <span class="text-xl font-bold text-base-content">
                        متجر <span class="text-warning">الكهرباء</span>
                    </span>
                </a>
                <p class="text-sm text-base-content/50 leading-relaxed mb-5">
                    نوفر لك أفضل المنتجات الكهربائية بجودة عالية وأسعار منافسة، لكل احتياجاتك الكهربائية في مكان واحد.
                </p>
                <div class="flex gap-2">
                    <a href="#" class="btn btn-circle btn-sm btn-ghost border border-base-content/10 hover:border-warning hover:text-warning">
                        <i class="fab fa-facebook-f text-xs"></i>
                    </a>
                    <a href="#" class="btn btn-circle btn-sm btn-ghost border border-base-content/10 hover:border-warning hover:text-warning">
                        <i class="fab fa-whatsapp text-xs"></i>
                    </a>
                    <a href="#" class="btn btn-circle btn-sm btn-ghost border border-base-content/10 hover:border-warning hover:text-warning">
                        <i class="fab fa-instagram text-xs"></i>
                    </a>
                    <a href="#" class="btn btn-circle btn-sm btn-ghost border border-base-content/10 hover:border-warning hover:text-warning">
                        <i class="fab fa-tiktok text-xs"></i>
                    </a>
                </div>
            </div>

            {{-- روابط سريعة --}}
            <div>
                <h3 class="text-xs font-semibold uppercase tracking-widest text-base-content mb-4 pb-3 border-b border-base-content/10">
                    روابط سريعة
                </h3>
                <ul class="flex flex-col gap-2.5">
                    <li>
                        <a href="{{ route('welcome') }}" class="text-sm text-base-content/50 hover:text-warning transition-colors no-underline">
                            الرئيسية
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('products.index') }}" class="text-sm text-base-content/50 hover:text-warning transition-colors no-underline">
                            جميع المنتجات
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('cart.index') }}" class="text-sm text-base-content/50 hover:text-warning transition-colors no-underline">
                            سلة المشتريات
                        </a>
                    </li>
                    @guest
                    <li>
                        <a href="{{ route('register.index') }}" class="text-sm text-base-content/50 hover:text-warning transition-colors no-underline">
                            إنشاء حساب
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('login') }}" class="text-sm text-base-content/50 hover:text-warning transition-colors no-underline">
                            تسجيل الدخول
                        </a>
                    </li>
                    @endguest
                </ul>
            </div>

            {{-- الأقسام --}}
            <div>
                <h3 class="text-xs font-semibold uppercase tracking-widest text-base-content mb-4 pb-3 border-b border-base-content/10">
                    الأقسام
                </h3>
                <ul class="flex flex-col gap-2.5">
                    <li>
                        <a href="{{ route('products.index') }}" class="text-sm text-base-content/50 hover:text-warning transition-colors no-underline">
                            كشافات
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('products.index') }}" class="text-sm text-base-content/50 hover:text-warning transition-colors no-underline">
                            أسلاك وكابلات
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('products.index') }}" class="text-sm text-base-content/50 hover:text-warning transition-colors no-underline">
                            لوحات توزيع
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('products.index') }}" class="text-sm text-base-content/50 hover:text-warning transition-colors no-underline">
                            إضاءة
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('products.index') }}" class="text-sm text-base-content/50 hover:text-warning transition-colors no-underline">
                            عدد وأدوات
                        </a>
                    </li>
                </ul>
            </div>

            {{-- تواصل معنا --}}
            <div>
                <h3 class="text-xs font-semibold uppercase tracking-widest text-base-content mb-4 pb-3 border-b border-base-content/10">
                    تواصل معنا
                </h3>
                <ul class="flex flex-col gap-3">
                    <li class="flex items-center gap-3 text-sm text-base-content/50">
                        <svg class="w-4 h-4 shrink-0 text-warning" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                        </svg>
                        01100700456
                    </li>
                    <li class="flex items-center gap-3 text-sm text-base-content/50">
                        <svg class="w-4 h-4 shrink-0 text-warning" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        info@electric-store.com
                    </li>
                    <li class="flex items-center gap-3 text-sm text-base-content/50">
                        <svg class="w-4 h-4 shrink-0 text-warning" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        القاهرة، مصر
                    </li>
                </ul>
            </div>

        </div>

        {{-- Bottom Bar --}}
        <div class="border-t border-base-content/10 py-5 flex flex-col sm:flex-row items-center justify-between gap-3 flex-wrap">
            <p class="text-xs text-base-content/35">
                © {{ date('Y') }} متجر <span class="text-warning">الكهرباء</span> — جميع الحقوق محفوظة
            </p>
            <div class="flex items-center gap-2 flex-wrap justify-center">
                <span class="badge badge-ghost badge-sm border border-base-content/10 text-base-content/45 gap-1">
                    🔒 دفع آمن
                </span>
                <span class="badge badge-ghost badge-sm border border-base-content/10 text-base-content/45 gap-1">
                    ✅ منتجات أصلية
                </span>
                <span class="badge badge-ghost badge-sm border border-base-content/10 text-base-content/45 gap-1">
                    🚚 شحن سريع
                </span>
            </div>
        </div>

    </div>
</footer>
