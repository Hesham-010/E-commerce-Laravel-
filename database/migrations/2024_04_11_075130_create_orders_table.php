<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->integer('key');
            $table->enum('order_status',['pending','processing','completed','canceled'])->default('pending');
            $table->float('totalPrice');
            $table->float('totalPriceAfterDiscount')->default(0);
            $table->text('shipping_address');
            $table->date('order_date');
            $table->boolean('isPaid')->default(false);
            $table->integer('postalCode');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('coupon_id')->nullable()->constrained('coupons');

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
