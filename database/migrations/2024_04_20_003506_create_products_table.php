<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->uuid('id')->primary()->default(DB::raw('UUID()'));
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('imageCover');
            $table->double('price');
            $table->string('colors');
            $table->integer('quantity');
            $table->integer('sold')->nullable();
            $table->integer('status')->default(1);

            $table->foreignId('sub_categories_id')->constrained('sub_categories')->onDelete('cascade');
            $table->foreignId('categories_id')->nullable()->constrained('categories')->onDelete('cascade');
            $table->foreignId('brands_id')->nullable()->constrained('brands')->onDelete('cascade');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
