<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('order_products', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->integer('quantity')->default(1);
            $table->float('unitPrice');
            $table->enum('size', ['xxxl','xxl', 'xl', 'l','m', 's']);
            $table->json('color')->nullable();

            $table->foreignId('order_id')->constrained('orders')->onDelete('cascade');

            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_product');
    }
};
