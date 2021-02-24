<?php declare(strict_types=1);

namespace App\Domains\User\Test\Feature;

class Logout extends FeatureAbstract
{
    /**
     * @var string
     */
    protected string $route = 'user.logout';

    /**
     * @return void
     */
    public function testGetUnauthorizedSuccess(): void
    {
        $this->get($this->route())
            ->assertStatus(302)
            ->assertRedirect(route('user.auth.credentials'));
    }

    /**
     * @return void
     */
    public function testGetSuccess(): void
    {
        $this->auth()
            ->get($this->route())
            ->assertStatus(302)
            ->assertRedirect(route('user.auth.credentials'));
    }
}
