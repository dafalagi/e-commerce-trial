<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class MigrateFresh extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:migrate-fresh';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Running migrate:fresh --seed command...');
        $this->call('migrate:fresh', ['--seed' => true]);
        $this->info('Migrate fresh completed.');

        // $this->call('passport:keys', ['--force' => true]);
        // $this->call('passport:client',['--personal' => true]);
    }
}
