<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id(); // Auto-incrementing primary key
            $table->string('sku')->unique(); 
            $table->string('name')->unique(); 
            $table->text('description')->nullable(); 
            $table->decimal('price', 8, 2); // Decimal with 8 digits total, 2 decimal places
            $table->integer('stock_quantity'); // Integer column
            $table->integer('unit'); //references units 
            $table->timestamps(); // Adds created_at and updated_at columns
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
