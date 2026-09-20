<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('earning_submissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('prompt_id')->constrained('earning_prompts')->cascadeOnDelete();
            $table->enum('type', ['sentence', 'word']);
            $table->string('language');
            $table->string('audio_path');
            $table->unsignedInteger('audio_duration')->nullable();
            $table->decimal('amount', 12, 2);
            $table->enum('status', ['completed'])->default('completed');
            $table->timestamp('reviewed_at')->nullable();
            $table->timestamps();

            $table->index(['user_id', 'type', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('earning_submissions');
    }
};
