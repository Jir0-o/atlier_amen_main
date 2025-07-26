<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('work_galleries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('work_id')
                  ->constrained('works')
                  ->cascadeOnDelete();
            $table->string('image_path'); 
            $table->string('image_path_low')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('work_galleries');
    }
};
