<?php declare(strict_types=1);

namespace App\Domains\User\Test\Feature;

use App\Domains\User\Mail\ConfirmStart as Mail;

class ConfirmStart extends FeatureAbstract
{
    /**
     * @var string
     */
    protected string $route = 'user.confirm.start';

    /**
     * @var string
     */
    protected string $action = 'confirmStart';

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
    public function testGetSuccess(): void
    {
        $this->userConfirm(false);

        $this->auth()
            ->get($this->route())
            ->assertStatus(200)
            ->assertViewIs('domains.user.confirm-start');
    }

    /**
     * @return void
     */
    public function testPostUnauthorizedFail(): void
    {
        $this->post($this->route())
            ->assertStatus(302)
            ->assertRedirect(route('user.auth.credentials'));
    }

    /**
     * @return void
     */
    public function testPostEmptySuccess(): void
    {
        $this->userConfirm(false);

        $this->auth()
            ->post($this->route())
            ->assertStatus(200)
            ->assertViewIs('domains.user.confirm-start');
    }

    /**
     * @return void
     */
    public function testPostSuccess(): void
    {
        $this->userConfirm(false);

        $mail = $this->mail();
        $mail->assertNothingSent();

        $this->auth()
            ->post($this->route(), $this->action())
            ->assertStatus(200)
            ->assertViewIs('domains.user.confirm-start-success');

        $mail->assertQueued(Mail::class, fn ($mail) => $mail->hasTo($this->user()->email));
    }

    /**
     * @return void
     */
    public function testPostRedirectSuccess(): void
    {
        $this->userConfirm(true);

        $this->auth()
            ->post($this->route(), $this->action())
            ->assertStatus(302)
            ->assertRedirect(route('dashboard.index'));

        $this->userConfirm(false);
    }
}
