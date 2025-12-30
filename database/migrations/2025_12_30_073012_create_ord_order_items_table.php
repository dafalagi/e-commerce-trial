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
        Schema::create('ord_order_items', function (Blueprint $table) {
            $table->id();
            $table->string('uuid');
            
            $table->integer('order_id');
            $table->integer('product_id');
            $table->string('product_name');
            $table->integer('quantity');
            $table->double('price');
            $table->double('total_price');

            $table->integer('is_active')->default(1);
            $table->integer('version')->default(0);
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->integer('deleted_by')->nullable();
            $table->integer('created_at')->nullable();
            $table->integer('updated_at')->nullable();
            $table->integer('deleted_at')->nullable();

            $table->index([
                'id',
                'order_id',
                'product_id',
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ord_order_items');
    }
};
