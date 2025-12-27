<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ClockworkCleanup extends Command
{
    /**
    * The console command name.
    *
    * @var string
    */
    protected $signature = 'clockwork:cleanup';

    /**
    * The console command description.
    *
    * @var string
    */
    protected $description = 'Cleans the app/storage/clockwork directory';

    /**
    * Create a new command instance.
    *
    * @return void
    */
    public function __construct()
    {
        parent::__construct();
    }

    /**
    * Execute the console command.
    *
    * @return void
    */
    public function handle()
    {
        $this->info('Cleaning app/storage/clockwork...');

        $files = scandir(storage_path().'/clockwork/');

        foreach($files as $file)
        {
            if(substr($file, -4) == "json")
            unlink(storage_path().'/clockwork/'.$file);

            if($file == 'index')
            unlink(storage_path().'/clockwork/'.$file);
        }

        $this->info('Done');
    }
}

