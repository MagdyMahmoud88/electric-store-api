<section class="py-16 px-5 md:px-10 bg-base-100">
    <div class="max-w-3xl mx-auto rounded-3xl p-14 text-center relative overflow-hidden reveal bg-base-200 border border-amber-400/20">
        <div class="absolute -top-16 left-1/2 -translate-x-1/2 w-[500px] h-[300px] pointer-events-none"
             style="background:radial-gradient(circle,rgba(245,158,11,0.07),transparent 70%);"></div>

        <h2 class="font-tajawal font-black mb-4 relative text-base-content" style="font-size:clamp(22px,3vw,38px);">
            مستعد تبدأ التسوق؟
        </h2>
        <p class="text-[15px] mb-8 relative text-base-content/40">
            انضم لآلاف العملاء الراضين واحصل على أفضل المنتجات بأفضل الأسعار
        </p>

        <div class="flex gap-3 justify-center flex-wrap relative">
            <a href="{{ route('products.index') }}"
               class="inline-flex items-center gap-2 px-7 py-3 rounded-2xl font-black text-[15px] transition-all duration-300 hover:-translate-y-1 bg-amber-400 text-neutral hover:shadow-[0_14px_36px_rgba(245,158,11,0.28)]">
                تسوق الآن
            </a>
            @guest
            <a href="{{ route('register.index') }}"
               class="inline-flex items-center gap-2 px-6 py-3 rounded-2xl font-bold text-[15px] transition-all duration-300 border border-base-content/10 text-base-content/70 hover:border-amber-400 hover:text-amber-400">
                إنشاء حساب مجاناً
            </a>
            @endguest
        </div>
    </div>
</section>
