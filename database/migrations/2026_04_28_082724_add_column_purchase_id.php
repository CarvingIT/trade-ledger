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
        Schema::table('line_items', function (Blueprint $table) {
            $table->bigInteger('invoice_id')->nullable()->change();
            $table->bigInteger('purchase_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('line_items', function (Blueprint $table) {
            $table->dropColumn('purchase_id');
        });
    }
};
