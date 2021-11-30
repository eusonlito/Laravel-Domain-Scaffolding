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
            'class' => $this::class,
            'payload' => $this->row->toArray(),
            'related_table' => Model::TABLE,
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
