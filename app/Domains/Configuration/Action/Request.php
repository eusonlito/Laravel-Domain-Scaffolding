<?php declare(strict_types=1);

namespace App\Domains\Configuration\Action;

use Illuminate\Support\Collection;
use App\Domains\Configuration\Model\Configuration as Model;

class Request extends ActionAbstract
{
    /**
     * @var \Illuminate\Support\Collection
     */
    protected Collection $list;

    /**
     * @return void
     */
    public function handle(): void
    {
        $this->list();
        $this->bind();
    }

    /**
     * @return void
     */
    public function list(): void
    {
        $this->list = Model::cache()->get()->keyBy('key');
    }

    /**
     * @return void
     */
    protected function bind(): void
    {
        app()->bind('configuration', fn () => $this->list);
    }
}
