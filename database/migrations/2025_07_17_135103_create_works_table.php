<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('works', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')
                  ->constrained('categories')
                  ->cascadeOnDelete();
            $table->string('name');
            $table->date('work_date')->nullable(); 
            $table->string('tags')->nullable();    
            $table->string('work_image')->nullable();
            $table->string('work_image_low')->nullable();
            $table->string('image_left_low')->nullable();
            $table->string('image_right_low')->nullable();
            $table->string('image_left')->nullable();
            $table->string('image_right')->nullable();
            $table->float('price')->default(0)->nullable();
            $table->integer('quantity')->default(0)->nullable();
            $table->string('art_video')->nullable();
            $table->longText('details')->nullable();
            $table->boolean('is_active')->default(true);
            $table->boolean('is_featured')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('works');
    }
};
