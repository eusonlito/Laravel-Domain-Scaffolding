<?php declare(strict_types=1);

namespace App\Domains\User\Action;

use App\Domains\User\Mail;
use App\Exceptions\ValidatorException;
use App\Domains\User\Model\User as Model;

class ConfirmStart extends ActionAbstract
{
    /**
     * @return \App\Domains\User\Model\User
     */
    public function handle(): Model
    {
        $this->check();
        $this->mail();

        return $this->row;
    }

    /**
     * @return void
     */
    protected function check(): void
    {
        if ($this->row->confirmed_at) {
            service()->message()->throw(new ValidatorException(__('validator.user-confirmed')));
        }
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
    protected function mail(): void
    {
        $this->factory()->mail()->confirmStart($this->row);
    }
}
