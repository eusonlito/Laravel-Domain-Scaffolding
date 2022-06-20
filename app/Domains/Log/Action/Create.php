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
        $main = current($this->data['related']);

        $this->data['action'] = $this->dataAction();
        $this->data['related_table'] = $main['related_table'];
        $this->data['related_id'] = $main['related_id'];
        $this->data['user_id'] = $this->auth->id ?? null;
    }

    /**
     * @return string
     */
    protected function dataAction(): string
    {
        return $this->data['action'] ?: (new ReflectionClass($this->data['class']))->getShortName();
    }

    /**
     * @return void
     */
    protected function save(): void
    {
        $this->saveRow();
        $this->saveRelated();
    }

    /**
     * @return void
     */
    protected function saveRow(): void
    {
        $this->row = Model::create([
            'action' => $this->data['action'],
            'related_table' => $this->data['related_table'],
            'related_id' => $this->data['related_id'],
            'payload' => $this->hidden($this->data['payload']),
            'user_id' => $this->data['user_id'],
        ]);
    }

    /**
     * @return void
     */
    protected function saveRelated(): void
    {
        foreach ($this->data['related'] as $each) {
            Model::insert([
                'action' => $this->data['action'],
                'related_table' => $each['related_table'],
                'related_id' => $each['related_id'],
                'payload' => json_encode($this->hidden($each['payload'])),
                'log_id' => $this->row->id,
                'user_id' => $this->data['user_id'],
            ]);
        }
    }

    /**
     * @param array $input
     *
     * @return array
     */
    protected function hidden(array $input): array
    {
        return helper()->arrayMapRecursive($input, function ($value, $key) {
            return $this->hiddenKey($key) ? 'HIDDEN' : $value;
        });
    }

    /**
     * @param string $key
     *
     * @return bool
     */
    protected function hiddenKey(string $key): bool
    {
        return str_contains($key, 'password')
            || str_contains($key, 'api_key');
    }
}
