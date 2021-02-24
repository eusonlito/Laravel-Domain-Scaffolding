<?php declare(strict_types=1);

namespace App\Domains\OPcache\Command;

use App\Domains\Shared\Command\CommandAbstract;

class Preload extends CommandAbstract
{
    /**
     * @var string
     */
    protected $signature = 'opcache:preload';

    /**
     * @var string
     */
    protected $description = 'Preload OPcache';

    /**
     * @return void
     */
    public function handle()
    {
        $this->info(json_decode($this->request(), true));
    }

    /**
     * @return string
     */
    protected function request(): string
    {
        return file_get_contents($this->route(), false, stream_context_create([
            'ssl' => [
                'verify_peer' => false,
                'verify_peer_name' => false,
            ],
        ]));
    }

    /**
     * @return string
     */
    protected function route(): string
    {
        return route('opcache.preload');
    }
}
