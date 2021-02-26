<?php declare(strict_types=1);

namespace App\Domains\Shared\Migration;

use Illuminate\Database\Connection;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Query\Expression;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Schema\ColumnDefinition;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

abstract class MigrationAbstract extends Migration
{
    /**
     * @var \Illuminate\Database\Connection
     */
    protected Connection $db;

    /**
     * @var string
     */
    protected string $driver;

    /**
     * @var \Illuminate\Database\Query\Expression
     */
    protected Expression $onUpdateCurrentTimestamp;

    /**
     * @return \Illuminate\Database\Connection
     */
    protected function db(): Connection
    {
        return $this->db ??= DB::connection();
    }

    /**
     * @return string
     */
    protected function driver(): string
    {
        return $this->driver ??= $this->db()->getDriverName();
    }

    /**
     * @param \Illuminate\Database\Schema\Blueprint $table
     *
     * @return void
     */
    protected function timestamps(Blueprint $table)
    {
        $this->dateTimeCreatedAt($table);
        $this->dateTimeUpdatedAt($table);
        $this->dateTimeDeletedAt($table);
    }

    /**
     * @param \Illuminate\Database\Schema\Blueprint $table
     *
     * @return \Illuminate\Database\Schema\ColumnDefinition
     */
    protected function dateTimeCreatedAt(Blueprint $table): ColumnDefinition
    {
        return $table->dateTime('created_at')->default($this->db()->raw('CURRENT_TIMESTAMP'));
    }

    /**
     * @param \Illuminate\Database\Schema\Blueprint $table
     *
     * @return \Illuminate\Database\Schema\ColumnDefinition
     */
    protected function dateTimeUpdatedAt(Blueprint $table): ColumnDefinition
    {
        return $table->dateTime('updated_at')->default($this->onUpdateCurrentTimestamp());
    }

    /**
     * @param \Illuminate\Database\Schema\Blueprint $table
     *
     * @return \Illuminate\Database\Schema\ColumnDefinition
     */
    protected function dateTimeDeletedAt(Blueprint $table): ColumnDefinition
    {
        return $table->dateTime('deleted_at')->nullable();
    }

    /**
     * @return \Illuminate\Database\Query\Expression
     */
    protected function onUpdateCurrentTimestamp(): Expression
    {
        if (isset($this->onUpdateCurrentTimestamp)) {
            return $this->onUpdateCurrentTimestamp;
        }

        if ($this->driver() === 'mysql') {
            $default = 'CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP';
        } else {
            $default = 'CURRENT_TIMESTAMP';
        }

        return $this->onUpdateCurrentTimestamp = $this->db()->raw($default);
    }

    /**
     * @param array $tables = []
     *
     * @return void
     */
    protected function drop(array $tables = [])
    {
        foreach (($tables ?: $this->getTables()) as $table) {
            Schema::dropIfExists($table);
        }
    }

    /**
     * @return array
     */
    protected function getTables(): array
    {
        $tables = $this->db()->getDoctrineSchemaManager()->listTableNames();

        return array_filter($tables, static fn ($table) => $table !== 'migrations');
    }
}
