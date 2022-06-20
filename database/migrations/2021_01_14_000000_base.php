<?php declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Domains\Shared\Migration\MigrationAbstract;

return new class extends MigrationAbstract
{
    /**
     * @return void
     */
    public function up()
    {
        $this->functions();
        $this->tables();
        $this->keys();
        $this->upFinish();
    }

    /**
     * @return void
     */
    protected function functions(): void
    {
        $this->database()->functionUpdatedAtNow();
    }

    /**
     * @return void
     */
    protected function tables()
    {
        Schema::create('configuration', function (Blueprint $table) {
            $table->id();

            $table->string('key')->unique();
            $table->string('value')->default('');
            $table->string('description')->default('');

            $table->boolean('public')->default(0);

            $table->dateTimeTz('created_at');
            $table->dateTimeTz('updated_at');
        });

        Schema::create('country', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('code')->unique();

            $table->boolean('default')->default(0);
            $table->boolean('enabled')->default(1);

            $table->dateTimeTz('created_at');
            $table->dateTimeTz('updated_at');
        });

        Schema::create('ip_lock', function (Blueprint $table) {
            $table->id();

            $table->string('ip')->default('');

            $table->dateTimeTz('end_at')->nullable();

            $table->dateTimeTz('created_at');
            $table->dateTimeTz('updated_at');
        });

        Schema::create('language', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('code')->unique();
            $table->string('locale')->unique();

            $table->boolean('default')->default(0);
            $table->boolean('enabled')->default(0);

            $table->dateTimeTz('created_at');
            $table->dateTimeTz('updated_at');
        });

        Schema::create('log', function (Blueprint $table) {
            $table->id();

            $table->string('action')->index();

            $table->string('related_table')->index();
            $table->unsignedBigInteger('related_id')->nullable()->index();

            $table->json('payload')->nullable();

            $table->dateTimeTz('created_at');
            $table->dateTimeTz('updated_at');

            $table->unsignedBigInteger('log_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
        });

        Schema::create('queue_fail', function (Blueprint $table) {
            $table->id();

            $table->text('connection');
            $table->text('queue');

            $table->longText('payload');
            $table->longText('exception');

            $table->dateTimeTz('failed_at')->useCurrent();

            $table->dateTimeTz('created_at');
            $table->dateTimeTz('updated_at');
        });

        Schema::create('user', function (Blueprint $table) {
            $table->id();

            $table->string('name')->default('');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('remember_token')->nullable();
            $table->string('timezone');

            $table->dateTimeTz('activated_at')->nullable();
            $table->dateTimeTz('confirmed_at')->nullable();
            $table->dateTimeTz('deleted_at')->nullable();

            $table->boolean('enabled')->default(0);

            $table->dateTimeTz('created_at');
            $table->dateTimeTz('updated_at');

            $table->unsignedBigInteger('language_id');
        });

        Schema::create('user_password_reset', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('hash')->index();
            $table->string('ip');

            $table->dateTimeTz('finished_at')->nullable();
            $table->dateTimeTz('canceled_at')->nullable();

            $table->dateTimeTz('created_at');
            $table->dateTimeTz('updated_at');

            $table->unsignedBigInteger('user_id');
        });

        Schema::create('user_session', function (Blueprint $table) {
            $table->id();

            $table->string('auth')->index();
            $table->string('ip')->index();

            $table->boolean('success')->default(0);

            $table->dateTimeTz('created_at');
            $table->dateTimeTz('updated_at');

            $table->unsignedBigInteger('user_id')->nullable();
        });
    }

    /**
     * Set the foreign keys.
     *
     * @return void
     */
    protected function keys()
    {
        Schema::table('log', function (Blueprint $table) {
            $table->index(['related_table', 'related_id']);
            $this->foreignOnDeleteSetNull($table, 'user');
        });

        Schema::table('user', function (Blueprint $table) {
            $this->foreignOnDeleteCascade($table, 'language');
        });

        Schema::table('user_password_reset', function (Blueprint $table) {
            $this->foreignOnDeleteCascade($table, 'user');
        });

        Schema::table('user_session', function (Blueprint $table) {
            $this->foreignOnDeleteSetNull($table, 'user');
        });
    }
};
