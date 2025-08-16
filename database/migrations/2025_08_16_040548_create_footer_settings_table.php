<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('footer_settings', function (Blueprint $table) {
            $table->id();
            $table->text('footer_text')->nullable();
            $table->string('facebook_url', 255)->nullable();
            $table->string('instagram_url', 255)->nullable();
            $table->string('website_url', 255)->nullable();
            $table->text('address')->nullable();
            $table->string('email', 255)->nullable();
            $table->timestamps();
        });


        DB::table('footer_settings')->insert([
            'footer_text'   => 'Atlier Amen',
            'facebook_url'  => 'https://www.facebook.com/',
            'instagram_url' => 'https://www.instagram.com/',
            'website_url'   => config('app.url'),
            'address'       => 'default address here',
            'email'         => 'default email here',
            'created_at'    => now(),
            'updated_at'    => now(),
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('footer_settings');
    }
};
