<?php declare(strict_types=1);

namespace App\Domains\Shared\Migration;

use Illuminate\Database\ConnectionInterface;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Query\Expression;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Schema\ColumnDefinition;
use Illuminate\Database\Schema\ForeignKeyDefinition;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

abstract class MigrationAbstract extends Migration
{
    /**
     * @var \Illuminate\Database\ConnectionInterface
     */
    protected ConnectionInterface $db;

    /**
     * @var string
     */
    protected string $driver;

    /**
     * @var \Illuminate\Database\Query\Expression
     */
    protected Expression $onUpdateCurrentTimestamp;

    /**
     * @return \Illuminate\Database\ConnectionInterface
     */
    protected function db(): ConnectionInterface
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
     * @param \Illuminate\Database\Schema\Blueprint $table
     * @param string $remote
     * @param ?string $alias = null
     *
     * @return \Illuminate\Database\Schema\ForeignKeyDefinition
     */
    protected function foreign(Blueprint $table, string $remote, ?string $alias = null): ForeignKeyDefinition
    {
        return $table->foreign(($alias ?: $remote).'_id', $this->foreignName($table, $remote, $alias))->references('id')->on($remote);
    }

    /**
     * @param \Illuminate\Database\Schema\Blueprint $table
     * @param string $remote
     * @param ?string $alias = null
     *
     * @return \Illuminate\Database\Schema\ForeignKeyDefinition
     */
    protected function foreignOnDeleteSetNull(Blueprint $table, string $remote, ?string $alias = null): ForeignKeyDefinition
    {
        return $this->foreign($table, $remote, $alias)->onDelete('SET NULL');
    }

    /**
     * @param \Illuminate\Database\Schema\Blueprint $table
     * @param string $remote
     * @param ?string $alias = null
     *
     * @return \Illuminate\Database\Schema\ForeignKeyDefinition
     */
    protected function foreignOnDeleteCascade(Blueprint $table, string $remote, ?string $alias = null): ForeignKeyDefinition
    {
        return $this->foreign($table, $remote, $alias)->onDelete('CASCADE');
    }

    /**
     * @param \Illuminate\Database\Schema\Blueprint $table
     * @param string $remote
     * @param ?string $alias = null
     *
     * @return string
     */
    protected function foreignName(Blueprint $table, string $remote, ?string $alias = null): string
    {
        $table = $table->getTable();
        $name = '_'.($alias ?: $remote).'_fk';
        $strlen = strlen($table.$name);

        if (($this->driver() === 'mysql') && ($strlen > 64)) {
            $table = substr($table, 0, 64 - $strlen);
        }

        return $table.$name;
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
