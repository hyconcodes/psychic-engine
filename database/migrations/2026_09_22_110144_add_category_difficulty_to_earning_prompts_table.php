<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('earning_prompts', function (Blueprint $table) {
            $table->string('category')->nullable()->after('language');
            $table->enum('difficulty', ['easy', 'medium', 'hard'])->default('easy')->after('category');
            $table->foreignId('created_by')->nullable()->after('difficulty')->constrained('users')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('earning_prompts', function (Blueprint $table) {
            $table->dropForeign(['created_by']);
            $table->dropColumn(['category', 'difficulty', 'created_by']);
        });
    }
};
