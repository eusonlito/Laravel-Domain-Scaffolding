<?php declare(strict_types=1);

namespace App\Domains\UserPasswordReset\Action;

use App\Domains\UserPasswordReset\Mail;
use App\Domains\User\Model\User as UserModel;
use App\Domains\UserPasswordReset\Model\UserPasswordReset as Model;

class Start extends ActionAbstract
{
    /**
     * @var \App\Domains\User\Model\User
     */
    protected UserModel $user;

    /**
     * @return \App\Domains\UserPasswordReset\Model\UserPasswordReset
     */
    public function handle(): Model
    {
        $this->check();
        $this->data();
        $this->user();
        $this->cancel();
        $this->create();
        $this->log();
        $this->mail();

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
    protected function data(): void
    {
        $this->data['email'] = strtolower($this->data['email']);
    }

    /**
     * @throws \App\Exceptions\NotFoundException
     *
     * @return void
     */
    protected function user(): void
    {
        $this->user = UserModel::where('email', $this->data['email'])->firstOr(static function () {
            helper()->notFound(__('user-password-reset-start.error.not-found'));
        });
    }

    /**
     * @return void
     */
    protected function cancel(): void
    {
        Model::available()->byUserId($this->user->id)->update([
            'canceled_at' => date('Y-m-d H:i:s'),
        ]);
    }

    /**
     * @return void
     */
    protected function create(): void
    {
        $this->row = Model::create([
            'hash' => helper()->uniqidReal(16),
            'ip' => $this->request->ip(),
            'user_id' => $this->user->id,
        ]);
    }

    /**
     * @return void
     */
    protected function log(): void
    {
        $this->factory('Log')->action([
            'table' => 'user-password-reset',
            'action' => 'start',
            'user_from_id' => $this->user->id,
            'user_id' => $this->user->id,
        ])->create();
    }

    /**
     * @return void
     */
    protected function mail(): void
    {
        $this->factory()->mail()->start($this->row, $this->user);
    }
}
