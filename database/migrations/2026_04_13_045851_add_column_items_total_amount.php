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
        Schema::table('invoices', function (Blueprint $table) {
            $table->decimal('total_amount',9,2)->default(0.00);
        });
        Schema::table('entities', function (Blueprint $table) {
            $table->string('GSTIN_number')->nullable;
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->dropColumn('total_amount');
        });
        Schema::table('entities', function (Blueprint $table) {
            $table->dropColumn('GSTIN_number');
        });
    }
};
