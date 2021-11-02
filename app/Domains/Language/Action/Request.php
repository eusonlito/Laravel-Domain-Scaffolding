<?php declare(strict_types=1);

namespace App\Domains\Language\Action;

use App\Domains\Language\Model\Language as Model;

class Request extends ActionAbstract
{
    /**
     * @return void
     */
    public function handle(): void
    {
        $this->code();
        $this->row();
        $this->set();
    }

    /**
     * @return void
     */
    public function code(): void
    {
        if (preg_match('/^[a-zA-Z]+/', (string)$this->request->header('Accept-Language'), $matches)) {
            $this->code = $matches[0];
        } else {
            $this->code = config('app.locale');
        }
    }

    /**
     * @return void
     */
    protected function row(): void
    {
        $this->row = $this->rowCode() ?: $this->rowDefault();
    }

    /**
     * @return ?\App\Domains\Language\Model\Language
     */
    protected function rowCode(): ?Model
    {
        return Model::enabled()->where('code', $this->code)->remember()->first();
    }

    /**
     * @return \App\Domains\Language\Model\Language
     */
    protected function rowDefault(): Model
    {
        return Model::enabled()->where('default', 1)->remember()->first();
    }

    /**
     * @return void
     */
    protected function set(): void
    {
        app()->setLocale($this->row->code);
        app()->bind('language', fn () => $this->row);
    }
}
