<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('wishlists', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('session_id', 100)->index();
            $table->foreignId('work_id')->constrained('works')->cascadeOnDelete();
            $table->timestamps();

            // Uniques to prevent duplicates
            $table->unique(['session_id', 'work_id'], 'uniq_session_work');
            $table->unique(['user_id', 'work_id'], 'uniq_user_work');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('wishlists');
    }
};
