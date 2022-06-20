<?php declare(strict_types=1);

namespace App\Domains\User\Action;

use App\Domains\User\Model\User as Model;
use App\Domains\Shared\Action\ActionFactoryAbstract;

class ActionFactory extends ActionFactoryAbstract
{
    /**
     * @var ?\App\Domains\User\Model\User
     */
    protected ?Model $row;

    /**
     * @return \App\Domains\User\Model\User
     */
    public function authCredentials(): Model
    {
        return $this->actionHandle(AuthCredentials::class, $this->validate()->authCredentials());
    }

    /**
     * @return \App\Domains\User\Model\User
     */
    public function authModel(): Model
    {
        return $this->actionHandle(AuthModel::class);
    }

    /**
     * @return \App\Domains\User\Model\User
     */
    public function confirmStart(): Model
    {
        return $this->actionHandleTransaction(ConfirmStart::class);
    }

    /**
     * @return \App\Domains\User\Model\User
     */
    public function confirmFinish(): Model
    {
        return $this->actionHandleTransaction(ConfirmFinish::class, $this->validate()->confirmFinish());
    }

    /**
     * @return void
     */
    public function logout(): void
    {
        $this->actionHandle(Logout::class);
    }

    /**
     * @return \App\Domains\User\Model\User
     */
    public function signup(): Model
    {
        return $this->actionHandleTransaction(Signup::class, $this->validate()->signup());
    }

    /**
     * @return \App\Domains\User\Model\User
     */
    public function updateApi(): Model
    {
        return $this->actionHandle(UpdateApi::class, $this->validate()->updateApi());
    }

    /**
     * @return \App\Domains\User\Model\User
     */
    public function updateProfile(): Model
    {
        return $this->actionHandle(UpdateProfile::class, $this->validate()->updateProfile());
    }
}
