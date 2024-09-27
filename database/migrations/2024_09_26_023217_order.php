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
        Schema::create('order', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('supplier_id')->nullable()->index();
            $table->foreignId('staff_id')->nullable()->index();
            $table->date('order_date');
            $table->integer('total_amount');
            $table->string('status');
        });

        Schema::create('order_item', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('order_id')->nullable();
            $table->foreignId('product_id')->nullable();
            $table->integer('quantity');
            $table->integer('unit_price');
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
