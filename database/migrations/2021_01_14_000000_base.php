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
        Schema::disableForeignKeyConstraints();

        $this->drop();

        Schema::enableForeignKeyConstraints();

        $this->tables();
        $this->keys();
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

            $this->timestamps($table);
        });

        Schema::create('country', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('iso')->unique();

            $table->boolean('default')->default(0);
            $table->boolean('enabled')->default(1);

            $this->timestamps($table);
        });

        Schema::create('ip_lock', function (Blueprint $table) {
            $table->id();

            $table->string('ip')->default('');

            $table->datetime('end_at')->nullable();

            $this->timestamps($table);
        });

        Schema::create('language', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('iso')->unique();

            $table->boolean('default')->default(0);
            $table->boolean('enabled')->default(0);

            $this->timestamps($table);
        });

        Schema::create('log', function (Blueprint $table) {
            $table->id();

            $table->string('table')->index();
            $table->string('action')->index();

            $table->json('payload')->nullable();

            $this->timestamps($table);

            $table->unsignedBigInteger('user_from_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
        });

        Schema::create('queue_fail', function (Blueprint $table) {
            $table->id();

            $table->text('connection');
            $table->text('queue');

            $table->longText('payload');
            $table->longText('exception');

            $table->timestamp('failed_at')->useCurrent();

            $this->timestamps($table);
        });

        Schema::create('text', function (Blueprint $table) {
            $table->id();

            $table->string('code')->unique();

            $table->json('title');

            $table->string('template');

            $this->timestamps($table);
        });

        Schema::create('user', function (Blueprint $table) {
            $table->id();

            $table->string('name')->default('');
            $table->string('email')->unique();
            $table->string('password')->nullable();
            $table->string('remember_token')->nullable();

            $table->datetime('activated_at')->nullable();
            $table->datetime('confirmed_at')->nullable();

            $table->boolean('enabled')->default(0);

            $this->timestamps($table);

            $table->unsignedBigInteger('language_id');
        });

        Schema::create('user_password_reset', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('hash')->index();
            $table->string('ip');

            $table->datetime('finished_at')->nullable();
            $table->datetime('canceled_at')->nullable();

            $this->timestamps($table);

            $table->unsignedBigInteger('user_id');
        });

        Schema::create('user_session', function (Blueprint $table) {
            $table->id();

            $table->string('auth')->index();
            $table->string('ip')->index();

            $table->boolean('success')->default(0);

            $this->timestamps($table);

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
            $this->foreignOnDeleteSetNull($table, 'user');
            $this->foreignOnDeleteSetNull($table, 'user', 'user_from');
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
