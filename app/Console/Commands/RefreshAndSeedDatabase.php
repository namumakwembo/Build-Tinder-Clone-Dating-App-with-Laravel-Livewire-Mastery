<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class RefreshAndSeedDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:refresh-seed';
    protected $description = 'Refresh database and run seeders';

    public function handle()
    {
        $this->call('migrate:fresh', [
            '--seed' => true,
        ]);
    }

}
