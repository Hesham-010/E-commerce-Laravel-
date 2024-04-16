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
        Schema::create('return_product', function (Blueprint $table) {
            $table->uuid('id')->primary()->default(DB::raw('UUID()'));
            $table->integer('quantity')->default(1);
            $table->float('unitPrice');

            $table->uuid('return_id');
            $table->foreign('return_id')->references('id')->on('returns')->onDelete('cascade');

            $table->uuid('product_id');
            $table->foreign('product_id')->references('id')->on('products');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('return_product');
    }
};
