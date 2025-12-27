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
        Schema::create('prd_products', function (Blueprint $table) {
            $table->id();
            $table->string('uuid');
            
            $table->string('name');
            $table->text('description')->nullable();
            $table->double('price')->default(0);
            $table->integer('stock_quantity')->default(0);

            $table->integer('is_active')->default(1);
            $table->integer('version')->default(0);
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->integer('deleted_by')->nullable();
            $table->integer('created_at')->nullable();
            $table->integer('updated_at')->nullable();
            $table->integer('deleted_at')->nullable();

            $table->index([
                'id'
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prd_products');
    }
};
