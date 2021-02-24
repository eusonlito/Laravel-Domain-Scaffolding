<?php declare(strict_types=1);

namespace App\Domains\UserPasswordReset\Test\Feature;

use App\Domains\UserPasswordReset\Mail\Start as Mail;

class Start extends FeatureAbstract
{
    /**
     * @var string
     */
    protected string $route = 'user-password-reset.start';

    /**
     * @var string
     */
    protected string $action = 'start';

    /**
     * @return void
     */
    public function testGetSuccess(): void
    {
        $this->get($this->route())
            ->assertStatus(200)
            ->assertViewIs('domains.user-password-reset.start');
    }

    /**
     * @return void
     */
    public function testPostEmptySuccess(): void
    {
        $this->post($this->route())
            ->assertStatus(200)
            ->assertViewIs('domains.user-password-reset.start');
    }

    /**
     * @return void
     */
    public function testPostEmptyWithActionFail(): void
    {
        $this->post($this->route(), $this->action())
            ->assertStatus(422)
            ->assertDontSee('validation.')
            ->assertDontSee('validator.');
    }

    /**
     * @return void
     */
    public function testPostBadEmailFail(): void
    {
        $this->post($this->route(), $this->action() + ['email' => uniqid()])
            ->assertStatus(422)
            ->assertDontSee('validation.')
            ->assertDontSee('validator.');
    }

    /**
     * @return void
     */
    public function testPostNotExistsFail(): void
    {
        $this->post($this->route(), $this->action() + ['email' => $this->faker()->companyEmail])
            ->assertStatus(404);
    }

    /**
     * @return void
     */
    public function testPostSuccess(): void
    {
        $data = $this->whitelist($this->user()->toArray(), ['email']);

        $mail = $this->mail();
        $mail->assertNothingSent();

        $this->post($this->route(), $data)
            ->assertStatus(200)
            ->assertViewIs('domains.user-password-reset.start-success');

        $mail->assertQueued(Mail::class, static fn ($mail) => $mail->hasTo($data['email']));
    }

    /**
     * @return void
     */
    public function testPostWithoutActionSuccess(): void
    {
        $mail = $this->mail();
        $mail->assertNothingSent();

        $this->post($this->route(), ['email' => $this->user()->email])
            ->assertStatus(200)
            ->assertViewIs('domains.user-password-reset.start');

        $mail->assertNothingSent();
    }
}
