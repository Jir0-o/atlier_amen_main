<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();

            $table->integer('total_qty');
            $table->decimal('subtotal', 10, 2);
            $table->decimal('shipping_charge', 10, 2)->default(0);
            $table->decimal('grand_total', 10, 2);

            $table->string('ship_fname');
            $table->string('ship_lname');
            $table->text('ship_address');
            $table->string('ship_city');
            $table->string('ship_state')->nullable();
            $table->string('ship_zip')->nullable();
            $table->string('ship_country');

            $table->string('bill_fname');
            $table->string('bill_lname');
            $table->text('bill_address');
            $table->string('bill_city');
            $table->string('bill_state')->nullable();
            $table->string('bill_zip')->nullable();
            $table->string('bill_country');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
