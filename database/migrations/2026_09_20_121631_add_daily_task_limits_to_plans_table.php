<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('plans', function (Blueprint $table) {
            $table->unsignedInteger('daily_voice_tasks')->default(5)->after('word_game_per_word');
            $table->unsignedInteger('daily_word_tasks')->default(5)->after('daily_voice_tasks');
        });
    }

    public function down(): void
    {
        Schema::table('plans', function (Blueprint $table) {
            $table->dropColumn(['daily_voice_tasks', 'daily_word_tasks']);
        });
    }
};
