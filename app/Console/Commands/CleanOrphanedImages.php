<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use App\Models\Product;

class CleanOrphanedImages extends Command
{
    // الاسم الذي ستكتبه في الـ Terminal لتشغيل الأمر
    protected $signature = 'images:clean';
    protected $description = 'حذف الصور التي ليس لها سجل في قاعدة البيانات لتوفير المساحة';

    public function handle()
    {
        $this->info('جاري فحص الصور اليتيمة...');

        // 1. الحصول على جميع الملفات في مجلد المنتجات
        $allFiles = Storage::disk('public')->files('products');

        // 2. الحصول على جميع روابط الصور المسجلة في قاعدة البيانات
        $dbImages = Product::pluck('image_url')->toArray();

        $deletedCount = 0;

        foreach ($allFiles as $file) {
            // 3. إذا كان الملف موجوداً في المجلد وغير موجود في قاعدة البيانات، احذفه
            if (!in_array($file, $dbImages)) {
                Storage::disk('public')->delete($file);
                $deletedCount++;
                $this->line("تم حذف: {$file}");
            }
        }

        if ($deletedCount > 0) {
            $this->success("اكتمل التنظيف! تم حذف {$deletedCount} صورة لا داعي لها.");
        } else {
            $this->info('المجلد نظيف تماماً، لا توجد صور لزيادة المساحة.');
        }
    }
}
