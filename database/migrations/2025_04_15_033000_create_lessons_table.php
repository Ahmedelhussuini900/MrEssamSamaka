<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('lessons', function (Blueprint $table) {
            $table->id();
            $table->foreignId('month_id')->constrained('months')->onDelete('cascade');
            $table->string('title');
            $table->string('video_url');
            $table->string('video_thumbnail')->nullable();
            $table->integer('video_duration')->nullable(); // في الدقائق

            // خيارات الفيديو
            $table->boolean('is_premium')->default(false);
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_active')->default(true);
            $table->integer('order')->default(0);
            $table->text('description')->nullable();
            $table->json('video_metadata')->nullable(); // للبيانات الإضافية مثل الجودة، الحجم، إلخ

            // إعدادات الامتحان
            $table->boolean('has_exam')->default(false);
            $table->integer('exam_duration')->nullable(); // في الدقائق
            $table->integer('passing_score')->nullable();
            $table->integer('max_attempts')->nullable();
            $table->json('exam_questions')->nullable(); // أسئلة الامتحان
            $table->json('exam_settings')->nullable(); // إعدادات إضافية للامتحان

            // إحصائيات وتتبع
            $table->integer('views_count')->default(0);
            $table->integer('downloads_count')->default(0);
            $table->decimal('rating', 3, 2)->nullable();
            $table->integer('rating_count')->default(0);

            // بيانات إضافية
            $table->json('additional_data')->nullable(); // لأي بيانات إضافية مستقبلية

            $table->timestamps();
            $table->softDeletes(); // للحذف الناعم
        });
    }

    public function down()
    {
        Schema::dropIfExists('lessons');
    }
};
