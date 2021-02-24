<?php declare(strict_types=1);

namespace App\Domains\User\Action;

use Illuminate\Support\Facades\Auth;

class Logout extends ActionAbstract
{
    /**
     * @return void
     */
    public function handle(): void
    {
        $this->attempt();
        $this->log();
    }

    /**
     * @return void
     */
    protected function attempt(): void
    {
        Auth::logout();
    }

    /**
     * @return void
     */
    protected function log(): void
    {
        $this->factory('Log')->action([
            'table' => 'user',
            'action' => 'auth.logout',
            'user_from_id' => $this->row->id,
            'user_id' => $this->row->id,
        ])->create();
    }
}
