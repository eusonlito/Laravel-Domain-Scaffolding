<?php declare(strict_types=1);

namespace App\Domains\User\Test\Feature;

class Disabled extends FeatureAbstract
{
    /**
     * @var string
     */
    protected string $route = 'user.disabled';

    /**
     * @return void
     */
    public function testGetUnauthorizedFail(): void
    {
        $this->get($this->route())
            ->assertStatus(302)
            ->assertRedirect(route('user.auth.credentials'));
    }

    /**
     * @return void
     */
    public function testGetEnabledFail(): void
    {
        $this->auth()
            ->get($this->route())
            ->assertStatus(302)
            ->assertRedirect(route('dashboard.index'));
    }

    /**
     * @return void
     */
    public function testGetSuccess(): void
    {
        $user = $this->user();
        $user->enabled = false;
        $user->save();

        $this->auth()
            ->get($this->route())
            ->assertStatus(200)
            ->assertViewIs('domains.'.$this->route);

        $user = $this->user();
        $user->enabled = true;
        $user->save();
    }
}
