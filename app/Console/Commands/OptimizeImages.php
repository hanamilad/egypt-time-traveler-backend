<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class OptimizeImages extends Command
{
    protected $signature = 'images:optimize 
                            {--quality=85 : جودة التحويل من 1 إلى 100}';

    protected $description = 'تحويل وضغط جميع الصور داخل storage/app/public إلى WebP مع تحديث المسارات في قاعدة البيانات.';

    public function handle()
    {
        $disk = 'public';
        $quality = (int) $this->option('quality');

        $this->info("🔍 جاري البحث عن الصور في جميع المجلدات داخل [storage/app/public]...");
        $manager = new ImageManager(new Driver());
        $files = Storage::disk($disk)->allFiles(); // يمر على كل المجلدات الفرعية

        $converted = 0;

        foreach ($files as $file) {
            $extension = strtolower(pathinfo($file, PATHINFO_EXTENSION));

            // استهداف صور JPG / PNG فقط
            if (!in_array($extension, ['jpg', 'jpeg', 'png'])) {
                continue;
            }

            $fullPath = Storage::disk($disk)->path($file);
            $webpPath = preg_replace('/\.(jpg|jpeg|png)$/i', '.webp', $file);
            $webpFullPath = Storage::disk($disk)->path($webpPath);

            try {
                $image = $manager->read($fullPath)->toWebp($quality);
                $image->save($webpFullPath);

                // حذف الصورة القديمة بعد نجاح التحويل
                Storage::disk($disk)->delete($file);

                $this->line("✅ تم التحويل إلى WebP: {$file}");
                $converted++;
            } catch (\Exception $e) {
                $this->error("❌ فشل في تحويل {$file}: {$e->getMessage()}");
            }
        }

        // تحديث المسارات في قاعدة البيانات
        $this->updateDatabasePaths();

        $this->info("🎉 تم تحويل {$converted} صورة بنجاح وتحديث المسارات في قاعدة البيانات!");
    }

    /**
     * تحديث المسارات في قاعدة البيانات (يبحث عن .jpg / .jpeg / .png ويبدلها بـ .webp)
     */
    protected function updateDatabasePaths()
    {
        $this->info("🗂️ جاري تحديث المسارات في قاعدة البيانات...");

        $tables = DB::select('SHOW TABLES');
        $dbName = env('DB_DATABASE');
        $tableKey = "Tables_in_{$dbName}";

        // الجداول التي سنتجاهلها لأنها لا تحتوي على صور
        $ignoreTables = ['cache', 'sessions', 'migrations', 'jobs', 'failed_jobs', 'password_reset_tokens'];

        foreach ($tables as $table) {
            $tableName = $table->$tableKey;

            if (in_array($tableName, $ignoreTables)) {
                continue;
            }

            $columns = DB::select("SHOW COLUMNS FROM `{$tableName}`");

            foreach ($columns as $column) {
                if (str_contains(strtolower($column->Type), 'char') || str_contains(strtolower($column->Type), 'text')) {
                    $colName = $column->Field;
                    $escapedCol = "`{$colName}`";

                    try {
                        $affected = DB::table($tableName)
                            ->whereRaw("{$escapedCol} REGEXP '\\.(jpg|jpeg|png)$'")
                            ->update([
                                $colName => DB::raw("
                                REPLACE(
                                    REPLACE(
                                        REPLACE({$escapedCol}, '.jpg', '.webp'),
                                    '.jpeg', '.webp'),
                                '.png', '.webp')
                            ")
                            ]);

                        if ($affected > 0) {
                            $this->line("🔄 تم تحديث {$affected} صف في جدول {$tableName}.{$colName}");
                        }
                    } catch (\Exception $e) {
                        $this->warn("⚠️ تخطي {$tableName}.{$colName} بسبب: {$e->getMessage()}");
                    }
                }
            }
        }

        $this->info("✅ تم تحديث المسارات في قاعدة البيانات بنجاح!");
    }
}
