<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('withdrawal_requests', function (Blueprint $table) {
            $table->decimal('deduct_amount', 12, 2)->nullable()->after('amount');
            $table->string('deduct_reason')->nullable()->after('decline_reason');
        });
    }

    public function down(): void
    {
        Schema::table('withdrawal_requests', function (Blueprint $table) {
            $table->dropColumn(['deduct_amount', 'deduct_reason']);
        });
    }
};
