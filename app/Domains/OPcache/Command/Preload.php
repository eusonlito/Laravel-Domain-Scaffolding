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
        $this->request();
    }

    /**
     * @return void
     */
    protected function request(): void
    {
        file_get_contents(route('opcache.preload'), false, stream_context_create([
            'ssl' => [
                'verify_peer' => false,
                'verify_peer_name' => false,
            ],
        ]));
    }
}
