<?php declare(strict_types=1);

namespace App\Domains\User\Action;

use Illuminate\Support\Facades\Hash;
use App\Domains\User\Model\User as Model;

class UpdateProfile extends ActionAbstract
{
    /**
     * @return \App\Domains\User\Model\User
     */
    public function handle(): Model
    {
        $this->data();
        $this->update();
        $this->log();

        return $this->row;
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
    protected function update(): void
    {
        $this->row->name = $this->data['name'];
        $this->row->email = $this->data['email'];

        if ($this->data['password']) {
            $this->row->password = Hash::make($this->data['password']);
        }

        $this->row->save();
    }

    /**
     * @return void
     */
    protected function log(): void
    {
        $this->factory('Log')->action([
            'table' => 'user',
            'action' => 'update-profile',
            'user_from_id' => $this->row->id,
            'user_id' => $this->row->id,
        ])->create();
    }
}
