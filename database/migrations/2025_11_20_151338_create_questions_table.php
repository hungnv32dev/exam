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
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->text('content'); // Nội dung câu hỏi chi tiết
            $table->string('youtube_url')->nullable(); // Link YouTube
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->string('category')->nullable(); // Danh mục câu hỏi
            $table->unsignedBigInteger('created_by'); // Admin tạo câu hỏi
            $table->timestamps();

            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            $table->index('status');
            $table->index('category');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('questions');
    }
};
