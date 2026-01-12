<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use ZipArchive;

class WeeklyDatabaseBackup extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:weekly-database-backup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Take weekly database backup and send via email';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $date = now()->format('Y-m-d_H-i-s');

        $backupDir = public_path('db/backups');
        if (!file_exists($backupDir)) {
            mkdir($backupDir, 0755, true);
        }

        $sqlFile = $backupDir . "/sg_db_backup_{$date}.sql";
        $zipFile = $backupDir . "/sg_db_backup_{$date}.zip";

        // DB details
        $dbHost = config('database.connections.mysql.host');
        $dbName = config('database.connections.mysql.database');
        $dbUser = config('database.connections.mysql.username');
        $dbPass = config('database.connections.mysql.password');

        // Detect OS
        $mysqldump = strtoupper(substr(PHP_OS, 0, 3)) === 'WIN'
            ? '"D:\xampp-install\mysql\bin\mysqldump.exe"'
            : 'mysqldump';

        // Password safe method
        putenv("MYSQL_PWD={$dbPass}");

        $command = "{$mysqldump} -h{$dbHost} -u{$dbUser} {$dbName} > \"{$sqlFile}\"";
        exec($command, $output, $result);

        putenv("MYSQL_PWD");

        if ($result !== 0 || !file_exists($sqlFile) || filesize($sqlFile) === 0) {
            $this->error('Database backup failed');
            return;
        }

        // ZIP the SQL file
        $zip = new ZipArchive;
        if ($zip->open($zipFile, ZipArchive::CREATE) === TRUE) {
            $zip->addFile($sqlFile, basename($sqlFile));
            $zip->close();
        } else {
            $this->error('ZIP creation failed');
            return;
        }

        // Delete raw SQL (security)
        unlink($sqlFile);

        // SEND EMAIL WITH ATTACHMENT
        Mail::raw(
            "Weekly database backup attached.\nDate: {$date}",
            function ($message) use ($zipFile) {
                $message->to(config('app.contact_email'))
                    ->subject('Weekly Database Backup')
                    ->attach($zipFile);
            }
        );

        $this->info('Database backup created and emailed successfully.');
    }
}
