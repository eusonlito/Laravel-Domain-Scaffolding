<?php declare(strict_types=1);

namespace App\Domains\User\Action;

use Illuminate\Contracts\Encryption\DecryptException;
use App\Exceptions\NotFoundException;
use App\Exceptions\ValidatorException;
use App\Domains\User\Model\User as Model;

class ConfirmFinish extends ActionAbstract
{
    /**
     * @return \App\Domains\User\Model\User
     */
    public function handle(): Model
    {
        $this->check();

        if ($this->row->confirmed_at) {
            return $this->row;
        }

        $this->confirm();
        $this->log();

        return $this->row;
    }

    /**
     * @return void
     */
    protected function check(): void
    {
        try {
            $id = (int)explode('|', decrypt($this->data['hash']))[0];
        } catch (DecryptException $e) {
            service()->message()->throw(new ValidatorException(__('user-confirm-finish.error.decrypt')));
        }

        $this->row = Model::byId($id)->firstOr(static function () {
            service()->message()->throw(new NotFoundException(__('user-confirm-finish.error.not-found')));
        });
    }

    /**
     * @return void
     */
    protected function confirm(): void
    {
        $this->row->confirmed_at = date('Y-m-d H:i:s');
        $this->row->save();
    }

    /**
     * @return void
     */
    protected function log(): void
    {
        $this->factory('Log')->action([
            'table' => 'user',
            'action' => 'confirm.finish',
            'user_from_id' => $this->row->id,
            'user_id' => $this->row->id,
        ])->create();
    }
}
