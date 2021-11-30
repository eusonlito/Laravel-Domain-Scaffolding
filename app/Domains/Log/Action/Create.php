<?php declare(strict_types=1);

namespace App\Domains\Log\Action;

use ReflectionClass;
use App\Domains\Log\Model\Log as Model;

class Create extends ActionAbstract
{
    /**
     * @return void
     */
    public function handle(): void
    {
        $this->data();
        $this->save();
    }

    /**
     * @return void
     */
    protected function data(): void
    {
        $this->data['action'] = $this->dataAction();
        $this->data['payload'] = json_encode($this->data['payload']);
        $this->data['user_id'] = $this->auth->id ?? null;
    }

    /**
     * @return string
     */
    protected function dataAction(): string
    {
        return $this->data['action'] ?: strtolower((new ReflectionClass($this->data['class']))->getShortName());
    }

    /**
     * @return void
     */
    protected function save(): void
    {
        Model::insert([
            'action' => $this->data['action'],
            'related_table' => $this->data['related_table'],
            'related_id' => $this->data['related_id'],
            'payload' => $this->data['payload'],
            'user_id' => $this->data['user_id'],
        ]);
    }
}
