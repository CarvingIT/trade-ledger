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
            $table->unsignedBigInteger('owner_entity_id')->nullable();
            $table->foreign('owner_entity_id')->references('id')->on('entities');
        });
        Schema::table('products', function (Blueprint $table) {
            $table->unsignedBigInteger('owner_entity_id')->nullable();
            $table->foreign('owner_entity_id')->references('id')->on('entities');
        });
        Schema::table('accounts', function (Blueprint $table) {
            $table->unsignedBigInteger('owner_entity_id')->nullable();
            $table->foreign('owner_entity_id')->references('id')->on('entities');
        });
        Schema::table('transactions', function (Blueprint $table) {
            $table->unsignedBigInteger('owner_entity_id')->nullable();
            $table->foreign('owner_entity_id')->references('id')->on('entities');
        });
        Schema::table('settings', function (Blueprint $table) {
            $table->unsignedBigInteger('owner_entity_id')->nullable();
            $table->foreign('owner_entity_id')->references('id')->on('entities');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->dropColumn('owner_entity_id');
        });
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('owner_entity_id');
        });
        Schema::table('accounts', function (Blueprint $table) {
            $table->dropColumn('owner_entity_id');
        });
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropColumn('owner_entity_id');
        });
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn('owner_entity_id');
        });
    }
};
