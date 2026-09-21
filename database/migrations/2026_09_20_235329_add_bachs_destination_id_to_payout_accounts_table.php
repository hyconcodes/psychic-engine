<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('payout_accounts', function (Blueprint $table) {
            $table->string('bachs_destination_id')->nullable()->after('account_name');
        });
    }

    public function down(): void
    {
        Schema::table('payout_accounts', function (Blueprint $table) {
            $table->dropColumn('bachs_destination_id');
        });
    }
};
