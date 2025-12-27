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
        Schema::create('auth_permissions', function (Blueprint $table) {
            $table->id();
            $table->string('uuid');

            $table->string('module_key')->unique();
            $table->string('module_name');
            $table->string('permission_name');

            $table->index([
                'id',
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('auth_permissions');
    }
};
