<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('earning_submissions', function (Blueprint $table) {
            $table->foreignId('withdrawal_request_id')->nullable()->after('prompt_id')->constrained()->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('earning_submissions', function (Blueprint $table) {
            $table->dropConstrainedForeignId('withdrawal_request_id');
        });
    }
};
