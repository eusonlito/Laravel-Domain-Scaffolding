<?php declare(strict_types=1);

namespace App\Domains\User\Action;

use App\Domains\User\Model\User as Model;

class UpdateApi extends ActionAbstract
{
    /**
     * @return \App\Domains\User\Model\User
     */
    public function handle(): Model
    {
        $this->data();
        $this->save();
        $this->logRow();

        return $this->row;
    }

    /**
     * @return void
     */
    protected function data(): void
    {
        $this->dataApiKey();
    }

    /**
     * @return void
     */
    protected function dataApiKey(): void
    {
        $this->data['api_key'] = $this->data['api_key'] ? $this->row->api_key : helper()->uuid();

        while ($this->dataApiKeyExists()) {
            $this->data['api_key'] = helper()->uuid();
        }
    }

    /**
     * @return bool
     */
    protected function dataApiKeyExists(): bool
    {
        return (bool)Model::byIdNot($this->row->id)->byApiKey($this->data['api_key'])->count();
    }

    /**
     * @return void
     */
    protected function save(): void
    {
        $this->row->api_key = $this->data['api_key'];
        $this->row->api_enabled = $this->data['api_enabled'];

        $this->row->save();
    }
}
