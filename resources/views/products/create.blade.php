<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إضافة منتج جديد - لوحة التحكم</title>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.7.2/dist/full.min.css" rel="stylesheet" type="text/css" />
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Tajawal', sans-serif; }
    </style>
</head>
<body class="bg-base-200 min-h-screen pb-10">

    <div class="navbar bg-base-100 shadow-md mb-8 px-8">
        <div class="flex-1">
            <a href="#" class="btn btn-ghost text-xl text-primary font-bold">إدارة المتجر</a>
        </div>
        <div class="flex-none">
            <a href="{{ route('products.index') }}" class="btn btn-outline btn-sm">العودة للمخزن</a>
        </div>
    </div>

    <div class="container mx-auto px-4">
        <div class="max-w-3xl mx-auto">

            @if ($errors->any())
                <div class="alert alert-error mb-6 shadow-lg">
                    <ul class="list-disc pr-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @if (session('success'))
    <div class="alert alert-success shadow-lg mb-6">
        <div>
            <span>{{ session('success') }}</span>
        </div>
    </div>
@endif

            <div class="card bg-base-100 shadow-2xl">
                <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" class="card-body">
                    @csrf

                    <div class="flex items-center gap-3 mb-6">
                        <div class="p-3 bg-primary/10 rounded-lg text-primary">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        </div>
                        <h2 class="card-title text-2xl font-bold">إضافة منتج كهربائي جديد</h2>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="form-control w-full">
                            <label class="label">
                                <span class="label-text font-bold text-lg">اسم المنتج</span>
                            </label>
                            <input type="text" name="name" placeholder="مثلاً: كشاف ليد 50 واط" class="input input-bordered focus:input-primary w-full" value="{{ old('name') }}" required />
                        </div>

                        <div class="form-control w-full">
                            <label class="label">
                                <span class="label-text font-bold text-lg">التصنيف</span>
                            </label>
                            <select name="category_id" class="select select-bordered focus:select-primary w-full" required>
                                <option disabled selected>اختر القسم...</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-control w-full">
                            <label class="label">
                                <span class="label-text font-bold text-lg">السعر (جنيه مصري)</span>
                            </label>
                            <label class="input input-bordered flex items-center gap-2">
                                <input type="number" name="price" step="0.01" class="grow" placeholder="0.00" value="{{ old('price') }}" required />
                                <span class="badge badge-ghost font-bold">EGP</span>
                            </label>
                        </div>

                        <div class="form-control w-full">
                            <label class="label">
                                <span class="label-text font-bold text-lg">الكمية المتوفرة</span>
                            </label>
                            <input type="number" name="stock" placeholder="مثلاً: 100" class="input input-bordered focus:input-primary w-full" value="{{ old('stock') }}" />
                        </div>
                    </div>

                    <div class="form-control w-full mt-4">
                        <label class="label">
                            <span class="label-text font-bold text-lg">وصف المنتج</span>
                        </label>
                        <textarea name="description" class="textarea textarea-bordered h-24 focus:textarea-primary" placeholder="اكتب تفاصيل المنتج الفنية هنا...">{{ old('description') }}</textarea>
                    </div>

                    <div class="form-control w-full mt-4">
                        <label class="label">
                            <span class="label-text font-bold text-lg">صورة المنتج الرئيسي</span>
                        </label>
                        <div class="flex flex-col items-center gap-4 p-6 border-2 border-dashed border-base-300 rounded-xl hover:border-primary transition-colors bg-base-50">
                            <input type="file" name="image_url" id="imageInput" class="file-input file-input-bordered file-input-primary w-full max-w-xs" accept="image/*" required />
                            <div id="previewContainer" class="hidden">
                                <img id="imagePreview" src="#" class="max-h-48 rounded-lg shadow-md border border-base-300" />
                            </div>
                        </div>
                    </div>

                    <div class="card-actions justify-end mt-10 gap-4">
                        <button type="reset" class="btn btn-ghost">مسح البيانات</button>
                        <button type="submit" class="btn btn-primary px-10">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M7.707 10.293a1 1 0 10-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L11 11.586V4a1 1 0 10-2 0v7.586l-1.293-1.293z" />
                                <path d="M5 17a2 2 0 01-2-2V7a2 2 0 012-2h3a1 1 0 010 2H5v8h10V9a1 1 0 112 0v6a2 2 0 01-2 2H5z" />
                            </svg>
                            حفظ المنتج في المخزن
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        imageInput.onchange = evt => {
            const [file] = imageInput.files
            if (file) {
                imagePreview.src = URL.createObjectURL(file)
                previewContainer.classList.remove('hidden')
            }
        }
    </script>
</body>
</html>
