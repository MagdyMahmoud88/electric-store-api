<x-layout title="تعديل القسم">
    <div class="p-6 bg-base-200 min-h-screen" dir="rtl" style="font-family:'Cairo', sans-serif;">
        <div class="max-w-2xl mx-auto">

            {{-- العنوان وزر العودة --}}
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold">تعديل القسم: <span class="text-primary">{{ $category->name }}</span></h1>
                <a href="{{ route('admin.categories.index') }}" class="btn btn-outline btn-sm">
                    ← عودة للقائمة
                </a>
            </div>

            {{-- كارت الفورم --}}
            <div class="card bg-base-100 shadow-sm border border-base-300 p-6">
                <form action="{{ route('admin.categories.update', $category) }}" method="POST">
                    @csrf
                    @method('PUT')

                    {{-- اسم القسم --}}
                    <div class="form-control w-full mb-4">
                        <label class="label"><span class="label-text font-bold">اسم القسم</span></label>
                        <input type="text" name="name" value="{{ old('name', $category->name) }}" class="input input-bordered w-full" required>
                        @error('name') <span class="text-error text-xs mt-1">{{ $message }}</span> @enderror
                    </div>

                    {{-- الـ Slug (اختياري) --}}
                    <div class="form-control w-full mb-4">
                        <label class="label"><span class="label-text font-bold">الرابط الصديق (Slug)</span></label>
                        <input type="text" name="slug" value="{{ old('slug', $category->slug) }}" placeholder="اتركه فارغاً للتوليد التلقائي" class="input input-bordered w-full">
                        @error('slug') <span class="text-error text-xs mt-1">{{ $message }}</span> @enderror
                    </div>

                    {{-- الحالة (Active/Inactive) --}}
                    <div class="form-control w-full mb-6">
                        <label class="label"><span class="label-text font-bold">حالة القسم</span></label>
                        <select name="status" class="select select-bordered w-full">
                            <option value="active" {{ old('status', $category->status) === 'active' ? 'selected' : '' }}>نشط (يظهر في الموقع)</option>
                            <option value="inactive" {{ old('status', $category->status) === 'inactive' ? 'selected' : '' }}>مخفي (لا يظهر في الموقع)</option>
                        </select>
                        @error('status') <span class="text-error text-xs mt-1">{{ $message }}</span> @enderror
                    </div>

                    {{-- أزرار التحكم --}}
                    <div class="flex justify-end gap-2">
                        <a href="{{ route('admin.categories.index') }}" class="btn btn-ghost">إلغاء</a>
                        <button type="submit" class="btn btn-primary px-8">حفظ التعديلات</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layout>
