<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();

            $table->foreignId('order_id')->constrained()->cascadeOnDelete();
            $table->foreignId('work_id')->constrained('works')->cascadeOnDelete();

            // Place these directly after work_id by position (no ->after() in CREATE)
            $table->unsignedBigInteger('work_variant_id')->nullable()->index();
            $table->string('variant_text')->nullable();

            $table->integer('quantity');
            $table->decimal('unit_price', 10, 2)->nullable();
            $table->decimal('line_total', 10, 2)->nullable();
            $table->timestamps();

            $table->foreign('work_variant_id')
                  ->references('id')
                  ->on('work_variants')
                  ->nullOnDelete(); 
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
