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
        Schema::create('fs_file_storages', function (Blueprint $table) {
            $table->id();
            $table->string('uuid');

            $table->string('size')->nullable();
            $table->string('extension')->nullable();
            $table->string('name')->unique()->nullable();
            $table->string('original_name')->nullable();
            $table->string('segment')->nullable();
            $table->string('filesystem');
            $table->text('location')->nullable();
            $table->string('remark')->nullable();
            $table->boolean('is_used')->default(0);

            $table->boolean('is_active')->default(1);
            $table->integer('version')->default(0);
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->integer('deleted_by')->nullable();
            $table->integer('created_at')->nullable();
            $table->integer('updated_at')->nullable();
            $table->integer('deleted_at')->nullable();

            $table->index(['id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fs_file_storages');
    }
};
