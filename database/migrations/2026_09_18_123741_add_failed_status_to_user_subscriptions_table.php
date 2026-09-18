<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $driver = DB::getDriverName();

        if ($driver === 'mysql') {
            DB::statement("ALTER TABLE user_subscriptions MODIFY COLUMN status ENUM('pending', 'active', 'expired', 'failed') NOT NULL DEFAULT 'pending'");

            return;
        }

        if ($driver === 'sqlite') {
            $this->rebuildSqlite(['pending', 'active', 'expired', 'failed']);
        }
    }

    public function down(): void
    {
        $driver = DB::getDriverName();

        if ($driver === 'mysql') {
            DB::statement("UPDATE user_subscriptions SET status = 'expired' WHERE status = 'failed'");
            DB::statement("ALTER TABLE user_subscriptions MODIFY COLUMN status ENUM('pending', 'active', 'expired') NOT NULL DEFAULT 'pending'");

            return;
        }

        if ($driver === 'sqlite') {
            $this->rebuildSqlite(['pending', 'active', 'expired']);
        }
    }

    private function rebuildSqlite(array $statuses): void
    {
        Schema::create('user_subscriptions_tmp', function (Blueprint $table) use ($statuses) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('plan_id')->constrained()->cascadeOnDelete();
            $table->enum('status', $statuses)->default('pending');
            $table->string('bachs_checkout_id')->nullable();
            $table->string('bachs_charge_id')->nullable();
            $table->timestamp('activated_at')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->timestamps();
            $table->index(['user_id', 'status']);
        });

        DB::statement('INSERT INTO user_subscriptions_tmp (id, user_id, plan_id, status, bachs_checkout_id, bachs_charge_id, activated_at, expires_at, created_at, updated_at)
            SELECT id, user_id, plan_id, status, bachs_checkout_id, bachs_charge_id, activated_at, expires_at, created_at, updated_at
            FROM user_subscriptions');

        Schema::drop('user_subscriptions');
        Schema::rename('user_subscriptions_tmp', 'user_subscriptions');
    }
};
