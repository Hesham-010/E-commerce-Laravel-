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
            $table->id()->autoIncrement();;
            $table->integer('key');
            $table->enum('orderState',['pending','processing','completed','canceled']);
            $table->float('totalPrice');
            $table->float('totalPriceAfterDiscount');
            $table->float('discountAmount');
            $table->string('city');
            $table->string('street');

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
