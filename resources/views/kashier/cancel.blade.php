<xlayout>
    @slot('title', 'عملية دفع غير مكتملة - المتجر الكهربائي')
    @slot('description', 'تم إلغاء أو فشل عملية الدفع الخاصة بطلبك. يمكنك إعادة المحاولة في أي وقت.')

    {{-- لتمرير أي ستايل مخصص سريع للصفحة --}}
    @push('styles')
        <style>
            @keyframes pulse-slow {
                0%, 100% { transform: scale(1); opacity: 0.2; }
                50% { transform: scale(1.05); opacity: 0.4; }
            }
            .bg-glow {
                animation: pulse-slow 4s ease-in-out infinite;
            }
        </style>
    @endpush

    <div class="min-h-[75vh] flex items-center justify-center p-4 bg-[#0b0c0e] relative overflow-hidden">

        {{-- تأثير توهج خلفي خافت متناسق مع هوية المتجر الكهربائي --}}
        <div class="absolute w-72 h-72 bg-error/10 rounded-full blur-[100px] top-1/4 left-1/3 bg-glow pointer-events-none"></div>
        <div class="absolute w-72 h-72 bg-warning/5 rounded-full blur-[120px] bottom-1/4 right-1/3 bg-glow pointer-events-none" style="animation-delay: 2s;"></div>

        {{-- الكارت الرئيسي المحمي --}}
        <div class="max-w-md w-full bg-[#111317] border border-white/5 rounded-2xl p-6 sm:p-8 text-center shadow-2xl relative z-10 backdrop-blur-md">

            {{-- دائرة الأيقونة التحذيرية بتأثير نبض ناعم --}}
            <div class="w-20 h-20 bg-error/10 border border-error/20 rounded-full flex items-center justify-center mx-auto mb-6 text-error">
                <svg class="w-10 h-10 animate-pulse" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
            </div>

            {{-- نصوص الحالة --}}
            <h1 class="text-xl sm:text-2xl font-black text-white mb-3 tracking-wide">الدفع لم يكتمل</h1>
            <p class="text-xs sm:text-sm text-white/60 leading-relaxed mb-6 px-2">
                {{ $message ?? 'تم إلغاء عملية الدفع أو لم تكتمل بنجاح من قِبل بوابة الدفع. لا تقلق، لم يتم خصم أي مبالغ من حسابك ويمكنك إعادة المحاولة.' }}
            </p>

            {{-- تفاصيل الطلب (تظهر فقط إذا تم تمرير بيانات الطلب من الـ Controller) --}}
            @if(isset($order))
                <div class="bg-[#1a1d24] border border-white/5 rounded-xl p-4 mb-6 text-right text-xs sm:text-sm text-white/70 space-y-2">
                    <div class="flex justify-between items-center border-b border-white/5 pb-2">
                        <span class="text-white/40">رقم الطلب التاريخي:</span>
                        <span class="font-mono font-bold text-white">#{{ $order->id }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-white/40">إجمالي المطلوب دفعه:</span>
                        <span class="text-warning font-black text-base">{{ number_format($order->total, 2) }} ج.م</span>
                    </div>
                </div>
            @endif

            {{-- أزرار التفاعل السريعة المريحة للمستخدم --}}
            <div class="flex flex-col gap-3">
                {{-- زر إعادة المحاولة وتوجيهه لصفحة الدفع المباشر أو السلة --}}
                <a href="{{ route('checkout.index') }}"
                   class="btn btn-sm h-11 bg-warning text-black hover:bg-warning/80 font-bold rounded-xl border-none shadow-lg shadow-warning/5 transition-all duration-300 flex items-center justify-center gap-2 text-xs sm:text-sm">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6" />
                    </svg>
                    <span>إعادة محاولة الدفع مجدداً</span>
                </a>

                {{-- زر العودة للرئيسية لمتابعة التصفح --}}
                <a href="{{ route('welcome') }}"
                   class="btn btn-sm h-11 bg-white/5 text-white/70 hover:bg-white/10 hover:text-white font-bold rounded-xl border border-white/5 transition-all duration-300 flex items-center justify-center text-xs sm:text-sm">
                    <span>العودة للرئيسية ومتابعة التسوق</span>
                </a>
            </div>

        </div>
    </div>
</xlayout>
