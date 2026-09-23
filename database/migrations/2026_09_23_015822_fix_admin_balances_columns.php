<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('admin_balances', function (Blueprint $table) {
            if (! Schema::hasColumn('admin_balances', 'user_id')) {
                $table->foreignId('user_id')->constrained()->onDelete('cascade');
                $table->decimal('amount', 10, 2);
                $table->foreignId('plan_id')->nullable()->constrained()->onDelete('set null');
                $table->text('description');
                $table->enum('status', ['pending', 'confirmed'])->default('pending');
                $table->timestamp('processed_at')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('admin_balances', function (Blueprint $table) {
            if (Schema::hasColumn('admin_balances', 'user_id')) {
                $table->dropForeign(['user_id']);
                $table->dropColumn(['user_id', 'amount', 'plan_id', 'description', 'status', 'processed_at']);
            }
        });
    }
};
