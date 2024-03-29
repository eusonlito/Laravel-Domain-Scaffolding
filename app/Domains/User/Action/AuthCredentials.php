<?php declare(strict_types=1);

namespace App\Domains\User\Action;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Exceptions\AuthenticationException;
use App\Domains\User\Model\User as Model;

class AuthCredentials extends ActionAbstract
{
    /**
     * @return \App\Domains\User\Model\User
     */
    public function handle(): Model
    {
        $this->data();
        $this->row();
        $this->check();
        $this->login();
        $this->auth();
        $this->logRow();
        $this->success();

        return $this->row;
    }

    /**
     * @return void
     */
    protected function data(): void
    {
        $this->dataEmail();
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
    protected function row(): void
    {
        $this->row = Model::byEmail($this->data['email'])->enabled()->firstOr(fn () => $this->fail());
    }

    /**
     * @return void
     */
    protected function check(): void
    {
        $this->checkPassword();
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
    protected function checkPassword(): void
    {
        if (Hash::check($this->data['password'], $this->row->password) === false) {
            $this->fail();
        }
    }

    /**
     * @throws \App\Exceptions\AuthenticationException
     *
     * @return void
     */
    protected function fail(): void
    {
        $this->factory('UserSession')->action(['auth' => $this->data['email']])->fail();

        service()->message()->throw(new AuthenticationException(__('user-auth-credentials.error.auth-fail')), 'validate');
    }

    /**
     * @return void
     */
    protected function login(): void
    {
        Auth::login($this->row, true);
    }

    /**
     * @return void
     */
    protected function auth(): void
    {
        $this->row = $this->auth = Auth::user();
    }

    /**
     * @return void
     */
    protected function success(): void
    {
        $this->factory('UserSession')->action(['auth' => $this->row->email])->success($this->row);
    }
}
