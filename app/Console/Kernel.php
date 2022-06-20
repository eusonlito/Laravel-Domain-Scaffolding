<?php declare(strict_types=1);

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as KernelVendor;
use App\Domains\Maintenance\Schedule\Manager as MaintenanceScheduleManager;
use App\Services\Filesystem\Directory;

class Kernel extends KernelVendor
{
    /**
     * @return void
     */
    protected function commands()
    {
        foreach (glob(app_path('Domains/*/Command')) as $dir) {
            $this->load($dir);
        }
    }

    /**
     * @param \Illuminate\Console\Scheduling\Schedule $schedule
     *
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $this->scheduleQueue($schedule);

        (new MaintenanceScheduleManager($schedule))->handle();
    }

    /**
     * @param \Illuminate\Console\Scheduling\Schedule $schedule
     *
     * @return void
     */
    protected function scheduleQueue(Schedule $schedule): void
    {
        $schedule->command('queue:work', ['--tries' => 3, '--stop-when-empty'])
            ->withoutOverlapping()
            ->runInBackground()
            ->appendOutputTo($this->log())
            ->everyMinute();
    }

    /**
     * @return string
     */
    protected function log(): string
    {
        $file = storage_path('logs/artisan/schedule-command-queue-work/'.date('Y-m-d').'.log');

        Directory::create($file, true);

        return $file;
    }
}
