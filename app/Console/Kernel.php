<?php declare(strict_types=1);

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as KernelVendor;
use App\Domains\Maintenance\Schedule\Manager as MaintenanceScheduleManager;

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
    protected function scheduleQueue(Schedule $schedule)
    {
        $schedule->command('queue:work --tries=3 --stop-when-empty')
            ->withoutOverlapping()
            ->runInBackground()
            ->appendOutputTo(storage_path('logs/artisan-queue-work.log'))
            ->everyMinute();
    }
}
