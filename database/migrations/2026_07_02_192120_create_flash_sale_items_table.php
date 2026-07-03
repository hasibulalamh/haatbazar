<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('flash_sale_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('flash_sale_id')->constrained()->cascadeOnDelete();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->decimal('flash_price', 10, 2); // the discounted price during the sale
            $table->unsignedInteger('stock_limit')->nullable(); // null = use product's normal stock
            $table->unsignedInteger('sold_count')->default(0); // for "X% sold" progress bar
            $table->timestamps();

            $table->unique(['flash_sale_id', 'product_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('flash_sale_items');
    }
};
