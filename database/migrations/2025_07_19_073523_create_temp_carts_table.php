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
            $table->unsignedInteger('quantity')->default(1);

            // Optional snapshot fields (so if Work changes later we still have info)
            $table->string('work_name')->nullable();
            $table->string('work_image_low')->nullable();


            $table->timestamps();

            $table->foreign('work_id')->references('id')->on('works')->cascadeOnDelete();
            $table->foreign('user_id')->references('id')->on('users')->nullOnDelete();

            $table->unique(['session_id', 'work_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('temp_carts');
    }
};
