<?php declare(strict_types=1);

namespace App\Domains\UserPasswordReset\Test\Feature;

class Finish extends FeatureAbstract
{
    /**
     * @var string
     */
    protected string $route = 'user-password-reset.finish';

    /**
     * @var string
     */
    protected string $action = 'finish';

    /**
     * @return void
     */
    public function testGetInvalidSuccess(): void
    {
        $this->get($this->route('', uniqid()))
            ->assertStatus(200)
            ->assertViewIs('domains.user-password-reset.finish');
    }

    /**
     * @return void
     */
    public function testPostInvalidSuccess(): void
    {
        $this->post($this->route('', uniqid()))
            ->assertStatus(200)
            ->assertViewIs('domains.user-password-reset.finish');
    }

    /**
     * @return void
     */
    public function testGetSuccess(): void
    {
        $this->get($this->route('', $this->row()->hash))
            ->assertStatus(200)
            ->assertViewIs('domains.user-password-reset.finish');
    }

    /**
     * @return void
     */
    public function testPostEmptySuccess(): void
    {
        $this->post($this->route('', $this->row()->hash))
            ->assertStatus(200)
            ->assertViewIs('domains.user-password-reset.finish');
    }

    /**
     * @return void
     */
    public function testPostInvalidShortFail(): void
    {
        $this->post($this->route('', uniqid()), $this->action() + ['password' => '123'])
            ->assertStatus(422)
            ->assertDontSee('validation.')
            ->assertDontSee('validator.');
    }

    /**
     * @return void
     */
    public function testPostShortFail(): void
    {
        $this->post($this->route('', $this->row()->hash), $this->action() + ['password' => '123'])
            ->assertStatus(422)
            ->assertDontSee('validation.')
            ->assertDontSee('validator.');
    }

    /**
     * @return void
     */
    public function testPostInvalidFail(): void
    {
        $this->post($this->route('', uniqid()), $this->whitelist($this->user()->toArray(), ['password']))
            ->assertStatus(404);
    }

    /**
     * @return void
     */
    public function testPostSuccess(): void
    {
        $this->post($this->route('', $this->row()->hash), $this->whitelist($this->user()->toArray(), ['password']))
            ->assertStatus(302)
            ->assertRedirect(route('user.auth.credentials'));
    }
}
