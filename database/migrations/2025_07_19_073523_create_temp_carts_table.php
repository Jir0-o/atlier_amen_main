<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('temp_carts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable()->index();
            $table->string('session_id', 100)->index();
            $table->unsignedBigInteger('work_id');
            $table->unsignedBigInteger('work_variant_id')->nullable()->index();
            $table->decimal('unit_price', 14, 2)->nullable();
            $table->unsignedInteger('quantity')->default(1);
            $table->string('variant_text')->nullable();
            $table->string('work_name')->nullable();
            $table->string('work_image_low')->nullable();
            $table->timestamps();

            // Foreign keys
            $table->foreign('work_id')->references('id')->on('works')->cascadeOnDelete();
            $table->foreign('user_id')->references('id')->on('users')->nullOnDelete();
            $table->foreign('work_variant_id', 'fk_work_variant_id')
                  ->references('id')->on('work_variants')
                  ->nullOnDelete();

            $table->unique(['session_id', 'work_id', 'work_variant_id'], 'uniq_session_work_variant');
            $table->unique(['user_id', 'work_id', 'work_variant_id'], 'uniq_user_work_variant');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('temp_carts');
    }
};
