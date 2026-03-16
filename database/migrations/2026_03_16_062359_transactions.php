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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id(); // Auto-incrementing primary key
            $table->bigInteger('entity_id');
            $table->string('type'); // Cr or Dr
            $table->text('description');
            $table->bigInteger('invoice_id')->nullable(); // only for credit transactions
            $table->bigInteger('account_id')->nullable(); // only for credit transactions
            $table->timestamps(); // Adds created_at and updated_at columns
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
