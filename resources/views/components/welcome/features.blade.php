<section class="py-16 px-5 md:px-10 bg-base-200">
    <div class="text-center max-w-xl mx-auto mb-12 reveal">
        <p class="text-[11px] font-bold tracking-[.15em] uppercase text-amber-400 mb-2">لماذا تختارنا</p>
        <h2 class="font-tajawal font-black text-base-content" style="font-size:clamp(22px,3vw,34px);">خدمة احترافية في كل خطوة</h2>
    </div>
    <div class="max-w-[1300px] mx-auto grid gap-4" style="grid-template-columns:repeat(auto-fit,minmax(240px,1fr));">
        @foreach([
            ['🚚','شحن سريع وموثوق','نوصل طلبك خلال 24 ساعة مع ضمان سلامة المنتجات'],
            ['✅','منتجات أصلية معتمدة','جميع منتجاتنا أصلية 100% بضمان كامل من الشركات المصنعة'],
            ['💰','أسعار تنافسية','نضمن أفضل الأسعار في السوق مع عروض وخصومات دورية'],
            ['🛠️','دعم فني متخصص','فريق متخصص لمساعدتك في اختيار المنتج المناسب لمشروعك'],
        ] as $i => $feat)
        <div class="feat-card reveal delay-{{ $i+1 }} rounded-2xl p-6 relative overflow-hidden transition-all duration-300 hover:-translate-y-1 bg-base-100 border border-base-content/10 hover:border-amber-400/25">
            <div class="w-12 h-12 rounded-xl flex items-center justify-center text-xl mb-4 bg-amber-400/10 border border-amber-400/20">
                {{ $feat[0] }}
            </div>
            <h3 class="text-[15px] font-black mb-2 text-base-content">{{ $feat[1] }}</h3>
            <p class="text-xs leading-[1.7] text-base-content/40">{{ $feat[2] }}</p>
        </div>
        @endforeach
    </div>
</section>
