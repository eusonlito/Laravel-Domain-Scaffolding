<?php declare(strict_types=1);

namespace App\Domains\User\Action;

use Illuminate\Support\Facades\Auth;
use App\Domains\User\Model\User as Model;

class AuthModel extends ActionAbstract
{
    /**
     * @return \App\Domains\User\Model\User
     */
    public function handle(): Model
    {
        $this->login();
        $this->auth();
        $this->log();
        $this->success();

        return $this->row;
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
    protected function log(): void
    {
        $this->factory('Log')->action([
            'table' => 'user',
            'action' => 'auth-model',
            'user_from_id' => $this->row->id,
            'user_id' => $this->row->id,
        ])->create();
    }

    /**
     * @return void
     */
    protected function success(): void
    {
        $this->factory('UserSession')->action()->success($this->row);
    }
}
