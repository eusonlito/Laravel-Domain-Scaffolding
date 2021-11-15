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
        $this->session();
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
            'action' => 'logout',
            'related_table' => 'user',
            'related_id' => $this->row->id,
        ])->create();
    }

    /**
     * @return void
     */
    protected function session(): void
    {
        $this->request->session()->flush();
    }
}
