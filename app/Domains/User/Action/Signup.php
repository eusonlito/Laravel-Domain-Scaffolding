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
        $this->data();
        $this->check();
        $this->save();
        $this->auth();
        $this->logRow();
        $this->notify();

        return $this->row;
    }

    /**
     * @return void
     */
    protected function data(): void
    {
        $this->dataEmail();
        $this->dataTimeZone();
    }

    /**
     * @return void
     */
    protected function dataEmail(): void
    {
        $this->data['email'] = strtolower($this->data['email']);
    }

    /**
     * @return void
     */
    protected function dataTimeZone(): void
    {
        $this->data['timezone'] = helper()->timezone($this->data['timezone']);
    }

    /**
     * @return void
     */
    protected function check(): void
    {
        $this->checkIp();
        $this->checkEmail();
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
    protected function checkEmail(): void
    {
        if (Model::byEmail($this->data['email'])->count()) {
            $this->exceptionValidator(__('validator.email-exists'));
        }
    }

    /**
     * @return void
     */
    protected function save(): void
    {
        $this->row = Model::create([
            'name' => $this->data['name'],
            'email' => $this->data['email'],
            'password' => Hash::make($this->data['password']),
            'timezone' => $this->data['timezone'],
            'enabled' => 1,
            'created_at' => date('c'),
            'updated_at' => date('c'),
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
    protected function notify(): void
    {
        $this->factory()->mail()->signup($this->row);
    }
}
