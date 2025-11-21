<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('exams', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Tên đợt thi
            $table->string('code')->unique(); // Mã đợt thi
            $table->integer('duration_minutes'); // Thời gian thi (phút)
            $table->datetime('start_time'); // Ngày giờ bắt đầu
            $table->datetime('end_time'); // Ngày giờ kết thúc
            $table->text('description')->nullable(); // Mô tả đợt thi
            $table->enum('status', ['draft', 'active', 'completed', 'cancelled'])->default('draft');
            $table->unsignedBigInteger('created_by'); // Admin tạo đợt thi
            $table->timestamps();

            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            $table->index(['status', 'start_time', 'end_time']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exams');
    }
};
