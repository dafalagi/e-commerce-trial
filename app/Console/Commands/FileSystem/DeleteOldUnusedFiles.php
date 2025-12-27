<?php

namespace App\Console\Commands\FileSystem;

use Illuminate\Console\Command;

class DeleteOldUnusedFiles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'file-system:delete-old-unused-files';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete old and unused files';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        try {
            $this->info('Deleting old unused files...');

            app('DeleteOldUnusedFilesService')->execute([]);

            $this->info('Old unused files deleted successfully.');
        } catch (\Exception $e) {
            $this->error('Error deleting old unused files: ' . $e->getMessage());
        }
    }
}
