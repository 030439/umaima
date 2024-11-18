<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;

class BackupDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'backup:db';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Backup the database and store it in the backups folder';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // Run the database backup using Spatie's Backup package
        $this->call('backup:run', [
            '--only-db' => true, // Backup only the database
        ]);

        $this->info('Database backup completed successfully.');
        return 0;
    }
}
