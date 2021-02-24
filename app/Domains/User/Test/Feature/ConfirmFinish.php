<?php declare(strict_types=1);

namespace App\Domains\User\Test\Feature;

class ConfirmFinish extends FeatureAbstract
{
    /**
     * @var string
     */
    protected string $route = 'user.confirm.finish';

    /**
     * @return void
     */
    public function testGetUnauthorizedFail(): void
    {
        $this->get($this->route('', uniqid()))
            ->assertStatus(422);
    }

    /**
     * @return void
     */
    public function testGetInvalidFail(): void
    {
        $this->auth()
            ->get($this->route('', uniqid()))
            ->assertStatus(422);
    }

    /**
     * @return void
     */
    public function testGetUnauthorizedSuccess(): void
    {
        $this->get($this->route('', $this->user()->idHash()))
            ->assertStatus(200)
            ->assertViewIs('domains.user.confirm-finish');

        $this->assertTrue($this->user()->confirmed_at !== null);
    }

    /**
     * @return void
     */
    public function testGetSuccess(): void
    {
        $this->userConfirm(false);

        $this->auth()
            ->get($this->route('', $this->user()->idHash()))
            ->assertStatus(200)
            ->assertViewIs('domains.user.confirm-finish');

        $this->assertTrue($this->user()->confirmed_at !== null);
    }
}
