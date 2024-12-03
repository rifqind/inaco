<?php

namespace App\Console;

use Carbon\Carbon;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\Facades\File;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Log;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // $schedule->command('inspire')->hourly();
        $schedule->call(function () {
            $tempFiles = File::files(public_path('temp/summernote'));
            foreach ($tempFiles as $file) {
                // If the file is older than 24 hours, delete it
                if (now()->diffInHours(Carbon::createFromTimestamp(File::lastModified($file))) > 24) {
                    File::delete($file);
                }
            }
        })->daily()->onSuccess(function () {
            Log::info('Daily temp file cleanup ran successfully.');
        })
            ->onFailure(function () {
                Log::error('Daily temp file cleanup failed.');
            });
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
