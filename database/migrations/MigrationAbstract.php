<?php declare(strict_types=1);

namespace Database\Migrations;

use Illuminate\Database\Connection;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
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
        $table->dateTime('created_at')->default($this->db()->raw('CURRENT_TIMESTAMP'));

        if ($this->driver() === 'mysql') {
            $default = 'CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP';
        } else {
            $default = 'CURRENT_TIMESTAMP';
        }

        $table->dateTime('updated_at')->default($this->db()->raw($default));
        $table->dateTime('deleted_at')->nullable();
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
