<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('earning_prompts', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['sentence', 'word']);
            $table->string('language');
            $table->text('text');
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index(['type', 'language', 'is_active']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('earning_prompts');
    }
};
