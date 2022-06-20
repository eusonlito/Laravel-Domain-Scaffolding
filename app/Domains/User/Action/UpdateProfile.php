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
        $this->save();
        $this->logRow();

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
    protected function save(): void
    {
        $this->row->name = $this->data['name'];
        $this->row->email = $this->data['email'];
        $this->row->timezone = $this->data['timezone'];

        if ($this->data['password']) {
            $this->row->password = Hash::make($this->data['password']);
        }

        $this->row->save();
    }
}
