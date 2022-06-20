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
        $this->logRow();

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
            $this->exceptionValidator(__('user-confirm-finish.error.decrypt'));
        }

        $this->row = Model::byId($id)->firstOr(function () {
            $this->exceptionNotFound(__('user-confirm-finish.error.not-found'));
        });
    }

    /**
     * @return void
     */
    protected function confirm(): void
    {
        $this->row->confirmed_at = date('c');
        $this->row->save();
    }
}
