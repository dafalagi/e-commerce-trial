<?php

namespace Database\Seeders;

use Database\Seeders\Auth\PermissionSeeder;
use Database\Seeders\Auth\RolePermissionSeeder;
use Database\Seeders\Auth\RoleSeeder;
use Database\Seeders\Auth\UserSeeder;
use Database\Seeders\Product\ProductSeeder;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            PermissionSeeder::class,
            ProductSeeder::class,
        ]);

        $this->call([
            UserSeeder::class,
            RolePermissionSeeder::class,
        ]);
    }
}
