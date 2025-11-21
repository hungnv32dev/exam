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
        Schema::create('exam_students', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('exam_id');
            $table->unsignedBigInteger('student_id');
            $table->datetime('registered_at')->nullable(); // Thời gian đăng ký
            $table->datetime('started_at')->nullable(); // Thời gian bắt đầu làm bài
            $table->datetime('submitted_at')->nullable(); // Thời gian nộp bài
            $table->enum('status', ['registered', 'in_progress', 'submitted', 'absent'])->default('registered');
            $table->timestamps();

            $table->foreign('exam_id')->references('id')->on('exams')->onDelete('cascade');
            $table->foreign('student_id')->references('id')->on('users')->onDelete('cascade');

            // Không cho phép sinh viên đăng ký trùng lặp trong cùng đợt thi
            $table->unique(['exam_id', 'student_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exam_students');
    }
};
