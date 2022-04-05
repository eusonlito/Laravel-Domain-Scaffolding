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
        $this->row();
        $this->set();
    }

    /**
     * @return void
     */
    protected function row(): void
    {
        $this->row = $this->rowSession()
            ?: $this->rowCode()
            ?: $this->rowDefault();
    }

    /**
     * @return ?\App\Domains\Language\Model\Language
     */
    protected function rowSession(): ?Model
    {
        if (empty($id = $this->request->session()->get('language_id'))) {
            return null;
        }

        return Model::byId($id)->first();
    }

    /**
     * @return ?\App\Domains\Language\Model\Language
     */
    protected function rowCode(): ?Model
    {
        return Model::byCode($this->rowCodeFromHeader())->first();
    }

    /**
     * @return string
     */
    protected function rowCodeFromHeader(): string
    {
        if (preg_match('/^[a-zA-Z]+/', (string)$this->request->header('Accept-Language'), $matches)) {
            return $matches[0];
        }

        return config('app.locale');
    }

    /**
     * @return \App\Domains\Language\Model\Language
     */
    protected function rowDefault(): Model
    {
        return Model::whereDefault(1)->first();
    }

    /**
     * @return void
     */
    protected function set(): void
    {
        $this->setLocale();
        $this->setBind();
        $this->setSession();
    }

    /**
     * @return void
     */
    protected function setLocale(): void
    {
        app()->setLocale($this->row->code);
    }

    /**
     * @return void
     */
    protected function setBind(): void
    {
        app()->bind('language', fn () => $this->row);
    }

    /**
     * @return void
     */
    protected function setSession(): void
    {
        $this->request->session()->put('language_id', $this->row->id);
    }
}
