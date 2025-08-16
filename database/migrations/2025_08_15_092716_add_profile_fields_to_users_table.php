<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('users', function (Blueprint $table) {
            $table->string('username', 100)->nullable()->unique()->after('last_name');
            $table->string('phone', 50)->nullable()->after('country');
            $table->date('date_of_birth')->nullable()->after('last_name');
            $table->boolean('is_active')->default(true)->after('date_of_birth');
            $table->boolean('is_verified')->default(false)->after('is_active');
        });
    }
    public function down(): void {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['username','phone','date_of_birth']);
        });
    }
};
