<?php declare(strict_types=1);

namespace App\Domains\UserPasswordReset\Action;

use Illuminate\Support\Facades\Hash;
use App\Exceptions\NotFoundException;
use App\Domains\User\Model\User as UserModel;
use App\Domains\UserPasswordReset\Model\UserPasswordReset as Model;

class Finish extends ActionAbstract
{
    /**
     * @var ?\App\Domains\User\Model\User
     */
    protected ?UserModel $user;

    /**
     * @return \App\Domains\UserPasswordReset\Model\UserPasswordReset
     */
    public function handle(): Model
    {
        $this->check();
        $this->row();
        $this->user();
        $this->update();
        $this->log();

        return $this->row;
    }

    /**
     * @return void
     */
    protected function check(): void
    {
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
    protected function row(): void
    {
        $this->row = Model::available()->where('hash', $this->data['hash'])->firstOr(static function () {
            throw new NotFoundException(__('user-password-reset-finish.error.not-found'));
        });
    }

    /**
     * @return void
     */
    protected function user(): void
    {
        $this->user = $this->row->user;
    }

    /**
     * @return void
     */
    protected function update(): void
    {
        $this->row->finished_at = date('Y-m-d H:i:s');
        $this->row->save();

        $this->user->password = Hash::make($this->data['password']);
        $this->user->save();
    }

    /**
     * @return void
     */
    protected function log(): void
    {
        $this->factory('Log')->action([
            'table' => 'user-password-reset',
            'action' => 'finish',
            'user_from_id' => $this->user->id,
            'user_id' => $this->user->id,
        ])->create();
    }
}
