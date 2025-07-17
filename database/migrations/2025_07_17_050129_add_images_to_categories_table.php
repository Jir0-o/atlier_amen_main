<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->string('category_image')->nullable()->after('slug');
            $table->string('image_left')->nullable()->after('category_image');
            $table->string('image_right')->nullable()->after('image_left');
        });
    }

    public function down(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->dropColumn(['category_image', 'image_left', 'image_right']);
        });
    }
};
