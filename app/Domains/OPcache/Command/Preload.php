<?php declare(strict_types=1);

namespace App\Domains\OPcache\Command;

use App\Domains\Shared\Command\CommandAbstract;

class Preload extends CommandAbstract
{
    /**
     * @var string
     */
    protected $signature = 'opcache:preload {--debug}';

    /**
     * @var string
     */
    protected $description = 'Preload OPcache';

    /**
     * @return void
     */
    public function handle()
    {
        $response = $this->request();

        if ($this->option('debug')) {
            $this->info(json_decode($response, true));
        }
    }

    /**
     * @return string
     */
    protected function request(): string
    {
        return file_get_contents(route('opcache.preload'), false, stream_context_create([
            'ssl' => [
                'verify_peer' => false,
                'verify_peer_name' => false,
            ],
        ]));
    }
}
