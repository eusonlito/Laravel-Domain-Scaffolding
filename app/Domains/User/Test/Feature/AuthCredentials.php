<?php declare(strict_types=1);

namespace App\Domains\User\Test\Feature;

use App\Domains\User\Model\User as Model;

class AuthCredentials extends FeatureAbstract
{
    /**
     * @var string
     */
    protected string $route = 'user.auth.credentials';

    /**
     * @var string
     */
    protected string $action = 'authCredentials';

    /**
     * @return void
     */
    public function testGetSuccess(): void
    {
        $this->get($this->route())
            ->assertStatus(200)
            ->assertViewIs('domains.user.auth-credentials');
    }

    /**
     * @return void
     */
    public function testPostEmptySuccess(): void
    {
        $this->post($this->route())
            ->assertStatus(200)
            ->assertViewIs('domains.user.auth-credentials');
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
    public function testPostEmptyUserFail(): void
    {
        $this->post($this->route(), $this->factoryWhitelist(Model::class, ['password']))
            ->assertStatus(422)
            ->assertDontSee('validation.')
            ->assertDontSee('validator.');
    }

    /**
     * @return void
     */
    public function testPostEmptyPasswordFail(): void
    {
        $this->post($this->route(), $this->factoryWhitelist(Model::class, ['email']))
            ->assertStatus(422)
            ->assertDontSee('validation.')
            ->assertDontSee('validator.');
    }

    /**
     * @return void
     */
    public function testPostBadEmailFail(): void
    {
        $data = $this->factoryWhitelist(Model::class, ['email', 'password']);
        $data['email'] = uniqid();

        $this->post($this->route(), $data)
            ->assertStatus(422)
            ->assertDontSee('validation.')
            ->assertDontSee('validator.');
    }

    /**
     * @return void
     */
    public function testPostInvalidFail(): void
    {
        $this->post($this->route(), $this->factoryWhitelist(Model::class, ['email', 'password']))
            ->assertStatus(401)
            ->assertDontSee('validation.')
            ->assertDontSee('validator.');
    }

    /**
     * @return void
     */
    public function testPostSuccess(): void
    {
        $this->post($this->route(), $this->whitelist($this->user()->toArray(), ['email', 'password']))
            ->assertStatus(302)
            ->assertRedirect(route('dashboard.index'));
    }

    /**
     * @return void
     */
    public function testPostWithoutActionSuccess(): void
    {
        $this->post($this->route(), $this->whitelist($this->user()->toArray(), ['email', 'password'], false))
            ->assertStatus(200);
    }
}
