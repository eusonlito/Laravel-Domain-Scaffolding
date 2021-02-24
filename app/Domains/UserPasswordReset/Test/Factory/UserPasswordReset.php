<?php declare(strict_types=1);

namespace App\Domains\UserPasswordReset\Test\Factory;

use Illuminate\Database\Eloquent\Factories\Factory as FactoryEloquent;
use App\Domains\User\Model\User as UserModel;
use App\Domains\UserPasswordReset\Model\UserPasswordReset as Model;

class UserPasswordReset extends FactoryEloquent
{
    /**
     * @var string
     */
    protected $model = Model::class;

    /**
     * @return array
     */
    public function definition()
    {
        return [
            'hash' => uniqid(),
            'ip' => $this->faker->ipv4,
            'user_id' => $this->user()->id,
        ];
    }

    /**
     * @return \App\Domains\User\Model\User
     */
    protected function user(): UserModel
    {
        return UserModel::orderBy('id', 'ASC')->firstOr(static fn () => UserModel::factory()->create());
    }
}
