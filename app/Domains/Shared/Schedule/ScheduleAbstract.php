<?php declare(strict_types=1);

namespace App\Domains\Shared\Schedule;

use Illuminate\Console\Scheduling\Event;
use Illuminate\Console\Scheduling\Schedule;
use App\Domains\Shared\Job\JobAbstract;
use App\Services\Filesystem\Directory;

abstract class ScheduleAbstract
{
    /**
     * @var \Illuminate\Console\Scheduling\Schedule
     */
    protected Schedule $schedule;

    /**
     * @return void
     */
    abstract public function handle(): void;

    /**
     * @param \Illuminate\Console\Scheduling\Schedule $schedule
     *
     * @return void
     */
    final public function __construct(Schedule $schedule)
    {
        $this->schedule = $schedule;
    }

    /**
     * @param string $command
     * @param string $log
     * @param array $arguments = []
     *
     * @return \Illuminate\Console\Scheduling\Event
     */
    final protected function command(string $command, string $log, array $arguments = []): Event
    {
        return $this->schedule->command($command, $arguments)->runInBackground()->appendOutputTo($this->log('command', $log));
    }

    /**
     * @param \App\Domains\Shared\Job\JobAbstract $job
     * @param string $log
     *
     * @return \Illuminate\Console\Scheduling\Event
     */
    final protected function job(JobAbstract $job, string $log): Event
    {
        return $this->schedule->job($job)->withoutOverlapping(60)->appendOutputTo($this->log('job', $log));
    }

    /**
     * @param string $type
     * @param string $name
     *
     * @return string
     */
    protected function log(string $type, string $name): string
    {
        $file = storage_path('logs/artisan/schedule-'.$type.'-'.str_slug($name).'/'.date('Y-m-d').'.log');

        Directory::create($file, true);

        return $file;
    }
}
