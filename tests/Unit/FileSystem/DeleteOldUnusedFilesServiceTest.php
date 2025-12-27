<?php

namespace Tests\Unit\FileSystem;

use App\Models\FileSystem\FileStorage;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class DeleteOldUnusedFilesServiceTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp(): void
    {
        parent::setUp();
    }

    public function test_success_delete_old_unused_files()
    {
        FileStorage::factory(2)->create([
            'created_at' => now()->subDays(30)->format('U'),
            'is_used' => false
        ]);

        $results = app('DeleteOldUnusedFilesService')->execute([]);

        $this->assertEmpty($results['data']);
        $this->assertDatabaseHas('fs_file_storages', [
            'created_at' => now()->subDays(30)->format('U'),
            'is_used' => false,
            'is_active' => false
        ]);
    }
}
