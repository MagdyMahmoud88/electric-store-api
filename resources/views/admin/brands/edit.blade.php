<x-layout>
    <div class="admin-page max-w-5xl mx-auto py-10 px-4 pb-32">

        {{-- Header Section --}}
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
            <div class="flex items-center gap-4">
                <a href="{{ route('admin.brands.index') }}" class="btn btn-square btn-outline border-base-content/20 hover:border-amber-500 hover:text-amber-500 transition-all duration-300">
                    <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
                    </svg>
                </a>
                <div>
                    <h1 class="text-2xl font-black tracking-tight">تعديل الماركة: <span class="text-primary">{{ $brand->name }}</span></h1>
                    <p class="text-xs text-base-content/50 font-bold uppercase mt-1">تحديث بيانات الهوية التجارية</p>
                </div>
            </div>

            <div class="flex gap-2">
                @if($brand->is_active)
                    <div class="badge badge-success badge-outline gap-2 py-3 px-4 font-bold">
                        <span class="relative flex h-2 w-2">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-success opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-success"></span>
                        </span>
                        نشط حالياً
                    </div>
                @else
                    <div class="badge badge-error badge-outline py-3 px-4 font-bold italic">متوقف</div>
                @endif
            </div>
        </div>

        {{-- Form Start --}}
        <form method="POST" action="{{ route('admin.brands.update', $brand) }}" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                {{-- Column 1 & 2: Main Content --}}
                <div class="lg:col-span-2 space-y-6">

                    {{-- Basic Info Card --}}
                    <div class="card bg-base-200 border border-base-content/10 shadow-xl">
                        <div class="card-body p-6">
                            <div class="flex items-center gap-2 mb-4 text-primary">
                                <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                                <h2 class="card-title text-sm font-bold italic">المعلومات الأساسية</h2>
                            </div>

                            <div class="form-control w-full">
                                <label class="label font-bold text-xs text-base-content/70 uppercase">اسم الماركة التجارية</label>
                                <input type="text" name="name" id="brand_name"
                                       class="input input-bordered focus:input-primary bg-base-300 w-full font-bold"
                                       value="{{ old('name', $brand->name) }}" required />
                                @error('name') <p class="text-error text-xs font-bold mt-1 px-1">{{ $message }}</p> @enderror
                            </div>

                            <div class="form-control w-full mt-4">
                                <label class="label font-bold text-xs text-base-content/70 uppercase">الوصف (اختياري)</label>
                                <textarea name="description" rows="4"
                                          class="textarea textarea-bordered focus:textarea-primary bg-base-300 font-bold leading-relaxed">{{ old('description', $brand->description) }}</textarea>
                            </div>
                        </div>
                    </div>

                    {{-- Visual Identity Card --}}
                    <div class="card bg-base-200 border border-base-content/10 shadow-xl overflow-hidden">
                        <div class="card-body p-6">
                            <div class="flex items-center gap-2 mb-4 text-primary">
                                <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                <h2 class="card-title text-sm font-bold italic">اللوجو الرسمي</h2>
                            </div>

                            <div class="flex flex-col md:flex-row gap-8 items-center">
                                {{-- Current Logo Display --}}
                                <div class="relative group">
                                    <div id="logo-preview" class="w-40 h-40 rounded-2xl bg-base-300 border-2 border-primary/20 flex items-center justify-center overflow-hidden shadow-2xl transition-transform group-hover:scale-[1.02]">
                                        @if($brand->logo)
                                            <img src="{{ asset('storage/' . $brand->logo) }}" class="w-full h-full object-contain p-4">
                                        @else
                                            <span class="text-4xl opacity-10 font-black italic">NO LOGO</span>
                                        @endif
                                    </div>
                                    <div class="absolute -top-3 -right-3 badge badge-primary font-bold shadow-lg">الحالي</div>
                                </div>

                                {{-- Upload New --}}
                                <div class="flex-grow w-full">
                                    <label class="relative flex flex-col items-center justify-center w-full h-40 border-2 border-dashed border-base-content/20 rounded-2xl cursor-pointer hover:bg-base-300 transition-all group overflow-hidden">
                                        <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                            <span class="text-3xl group-hover:bounce transition-all">📸</span>
                                            <p class="mt-2 text-sm font-black">رفع لوجو جديد</p>
                                            <p class="text-[10px] opacity-50 font-bold mt-1 uppercase">سيتم استبدال اللوجو الحالي تلقائياً</p>
                                        </div>
                                        <input type="file" name="logo" id="logo-input" accept="image/*" class="absolute inset-0 opacity-0 cursor-pointer" />
                                    </label>
                                    @error('logo') <p class="text-error text-xs font-bold mt-2 text-center">{{ $message }}</p> @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Column 3: Sidebar --}}
                <div class="space-y-6">
                    <div class="card bg-base-200 border border-base-content/10 shadow-xl">
                        <div class="card-body p-6">
                            <h2 class="font-black text-[10px] uppercase opacity-40 mb-4 tracking-[0.2em] text-center italic">Advanced Settings</h2>

                            <div class="form-control w-full">
                                <label class="label font-bold text-xs opacity-70 italic">SEO SLUG</label>
                                <input type="text" name="slug" id="brand_slug" dir="ltr"
                                       class="input input-bordered input-sm bg-base-300 font-mono text-xs focus:input-primary"
                                       value="{{ old('slug', $brand->slug) }}" />
                            </div>

                            <div class="form-control w-full mt-4">
                                <label class="label font-bold text-xs opacity-70 italic">SORT ORDER</label>
                                <input type="number" name="sort_order"
                                       class="input input-bordered input-sm bg-base-300 font-bold focus:input-primary"
                                       value="{{ old('sort_order', $brand->sort_order) }}" />
                            </div>

                            <div class="divider opacity-5 my-6"></div>

                            <div class="flex items-center justify-between p-4 bg-primary/5 rounded-2xl border border-primary/10">
                                <div class="flex flex-col">
                                    <span class="font-black text-sm uppercase tracking-tighter">Status</span>
                                    <span class="text-[10px] opacity-60 font-bold">ظهور في المتجر</span>
                                </div>
                                <input type="checkbox" name="is_active" value="1"
                                       class="toggle toggle-primary toggle-lg shadow-sm"
                                       {{ old('is_active', $brand->is_active) ? 'checked' : '' }} />
                            </div>
                        </div>
                    </div>

                    {{-- Info Box --}}
                    <div class="alert bg-base-200 border-base-content/5 shadow-sm rounded-2xl">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="stroke-info shrink-0 w-6 h-6"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <div class="text-[11px] font-bold leading-relaxed opacity-70 italic uppercase">
                            تاريخ الإضافة: {{ $brand->created_at->format('Y-m-d') }}<br>
                            آخر تحديث: {{ $brand->updated_at->diffForHumans() }}
                        </div>
                    </div>
                </div>
            </div>

            {{-- Sticky Footer Actions --}}
            <div class="fixed bottom-0 left-0 right-0 p-4 md:p-6 bg-base-200/90 backdrop-blur-xl border-t border-base-content/10 z-[100] shadow-[0_-10px_40px_rgba(0,0,0,0.3)]">
                <div class="max-w-5xl mx-auto flex flex-col-reverse md:flex-row gap-4 items-center justify-end">

                    <a href="{{ route('admin.brands.index') }}"
                       class="btn btn-ghost btn-sm md:btn-md font-bold px-8 hover:bg-error/10 hover:text-error transition-all">
                        تجاهل التغييرات
                    </a>

                    <button type="submit"
                            class="btn btn-primary md:px-12 gap-4 shadow-2xl shadow-primary/30 w-full md:w-auto group transform transition active:scale-95">
                        <span class="font-black text-base uppercase tracking-tight">حفظ التحديثات</span>
                        <div class="bg-primary-content/20 p-1.5 rounded-lg group-hover:rotate-12 transition-transform">
                            <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                            </svg>
                        </div>
                    </button>

                </div>
            </div>
        </form>
    </div>

    <script>
        // معاينة حية للصورة المرفوعة حديثاً
        document.getElementById('logo-input').addEventListener('change', function(e) {
            const preview = document.getElementById('logo-preview');
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = (event) => {
                    preview.innerHTML = `<img src="${event.target.result}" class="w-full h-full object-contain p-4 animate-in zoom-in duration-500">`;
                }
                reader.readAsDataURL(file);
            }
        });

        // الـ Slug يظل اختيارياً (لا يتولد تلقائياً في التعديل إلا لو مسحت القديم لعدم تخريب الـ SEO)
        document.getElementById('brand_name').addEventListener('input', function() {
            const slugInput = document.getElementById('brand_slug');
            if(slugInput.value === "") {
                slugInput.value = this.value.toLowerCase().trim()
                    .replace(/[^\w\s-]/g, '').replace(/[\s_-]+/g, '-').replace(/^-+|-+$/g, '');
            }
        });
    </script>
</x-layout>
