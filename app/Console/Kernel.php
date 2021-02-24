<?php declare(strict_types=1);

namespace App\Console;

use Illuminate\Foundation\Console\Kernel as KernelVendor;

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
}
