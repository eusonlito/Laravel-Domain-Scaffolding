<?php declare(strict_types=1);

namespace App\Domains\Log\Action;

use App\Domains\Log\Model\Log as Model;

class Create extends ActionAbstract
{
    /**
     * @return void
     */
    public function handle(): void
    {
        $this->store();
    }

    /**
     * @return void
     */
    protected function store(): void
    {
        Model::insert($this->data());
    }

    /**
     * @return array
     */
    protected function data(): array
    {
        return [
            'action' => $this->data['action'],
            'related_table' => $this->data['related_table'],
            'related_id' => $this->data['related_id'],
            'payload' => helper()->jsonEncode($this->data['payload']),
            'user_id' => $this->auth->id ?? null,
        ];
    }
}
