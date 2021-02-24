<?php declare(strict_types=1);

namespace App\Domains\User\Test\Feature;

use App\Domains\User\Mail\Signup as Mail;
use App\Domains\User\Model\User as Model;

class Signup extends FeatureAbstract
{
    /**
     * @var string
     */
    protected string $route = 'user.signup';

    /**
     * @var string
     */
    protected string $action = 'signup';

    /**
     * @return void
     */
    public function testGetSuccess(): void
    {
        $this->get($this->route())
            ->assertStatus(200)
            ->assertViewIs('domains.user.signup');
    }

    /**
     * @return void
     */
    public function testPostEmptySuccess(): void
    {
        $this->post($this->route())
            ->assertStatus(200)
            ->assertViewIs('domains.user.signup');
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
    public function testPostEmptyNameFail(): void
    {
        $this->post($this->route(), $this->factoryWhitelist(Model::class, ['email', 'password']))
            ->assertStatus(422)
            ->assertDontSee('validation.')
            ->assertDontSee('validator.');
    }

    /**
     * @return void
     */
    public function testPostEmptyEmailFail(): void
    {
        $this->post($this->route(), $this->factoryWhitelist(Model::class, ['name', 'password']))
            ->assertStatus(422)
            ->assertDontSee('validation.')
            ->assertDontSee('validator.');
    }

    /**
     * @return void
     */
    public function testPostEmptyPasswordFail(): void
    {
        $this->post($this->route(), $this->factoryWhitelist(Model::class, ['name', 'email']))
            ->assertStatus(422)
            ->assertDontSee('validation.')
            ->assertDontSee('validator.');
    }

    /**
     * @return void
     */
    public function testPostEmptyConditionsFail(): void
    {
        $this->post($this->route(), $this->factoryWhitelist(Model::class, ['name', 'email', 'password']))
            ->assertStatus(422)
            ->assertDontSee('validation.')
            ->assertDontSee('validator.');
    }

    /**
     * @return void
     */
    public function testPostBadEmailFail(): void
    {
        $data = $this->factoryWhitelist(Model::class, ['name', 'password']);
        $data['email'] = uniqid();

        $this->post($this->route(), $data)
            ->assertStatus(422)
            ->assertDontSee('validation.')
            ->assertDontSee('validator.');
    }

    /**
     * @return void
     */
    public function testPostBadPasswordFail(): void
    {
        $data = $this->factoryWhitelist(Model::class, ['name', 'email']);
        $data['password'] = '123';

        $this->post($this->route(), $data)
            ->assertStatus(422)
            ->assertDontSee('validation.')
            ->assertDontSee('validator.');
    }

    /**
     * @return void
     */
    public function testPostSuccess(): void
    {
        $data = $this->factoryWhitelist(Model::class, ['name', 'email', 'password']);
        $data['conditions'] = 1;

        $mail = $this->mail();
        $mail->assertNothingSent();

        $this->post($this->route(), $data)
            ->assertStatus(302)
            ->assertRedirect(route('dashboard.index'));

        $mail->assertQueued(Mail::class, static fn ($mail) => $mail->hasTo($data['email']));
    }

    /**
     * @return void
     */
    public function testPostRepeatFail(): void
    {
        $data = $this->whitelist($this->user()->toArray(), ['name', 'email', 'password']);
        $data['conditions'] = 1;

        $this->post($this->route(), $data)
            ->assertStatus(422)
            ->assertDontSee('validation.')
            ->assertDontSee('validator.');
    }

    /**
     * @return void
     */
    public function testPostWithoutActionSuccess(): void
    {
        $data = $this->factoryWhitelist(Model::class, ['name', 'email', 'password'], false);
        $data['conditions'] = 1;

        $mail = $this->mail();
        $mail->assertNothingSent();

        $this->post($this->route(), $data)
            ->assertStatus(200)
            ->assertViewIs('domains.user.signup');

        $mail->assertNothingSent();
    }

    /**
     * @return void
     */
    public function testPostOtherSuccess(): void
    {
        $data = $this->factoryWhitelist(Model::class, ['name', 'email', 'password']);
        $data['conditions'] = 1;

        $mail = $this->mail();
        $mail->assertNothingSent();

        $this->post($this->route(), $data)
            ->assertStatus(302)
            ->assertRedirect(route('dashboard.index'));

        $mail->assertQueued(Mail::class, static fn ($mail) => $mail->hasTo($data['email']));
    }
}
