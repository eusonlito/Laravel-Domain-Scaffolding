<?php declare(strict_types=1);

namespace App\Domains\User\Action;

use Illuminate\Support\Facades\Hash;
use App\Domains\User\Model\User as Model;

class Signup extends ActionAbstract
{
    /**
     * @return \App\Domains\User\Model\User
     */
    public function handle(): Model
    {
        $this->check();
        $this->data();
        $this->create();
        $this->auth();
        $this->log();
        $this->notify();

        return $this->row;
    }

    /**
     * @return void
     */
    protected function check(): void
    {
        $this->checkIp();
    }

    /**
     * @return void
     */
    protected function checkIp(): void
    {
        $this->factory('IpLock')->action()->check();
    }

    /**
     * @return void
     */
    protected function data(): void
    {
        $this->data['email'] = strtolower($this->data['email']);
    }

    /**
     * @return void
     */
    protected function create(): void
    {
        $this->row = Model::create([
            'name' => $this->data['name'],
            'email' => $this->data['email'],
            'password' => Hash::make($this->data['password']),
            'enabled' => 1,
            'language_id' => app('language')->id,
        ]);
    }

    /**
     * @return void
     */
    protected function auth(): void
    {
        $this->auth = $this->factory()->action()->authModel();
    }

    /**
     * @return void
     */
    protected function log(): void
    {
        $this->factory('Log')->action([
            'class' => $this::class,
            'payload' => $this->row->toArray(),
            'related_table' => Model::TABLE,
            'related_id' => $this->row->id,
        ])->create();
    }

    /**
     * @return void
     */
    protected function notify(): void
    {
        $this->factory()->mail()->signup($this->row);
    }
}
