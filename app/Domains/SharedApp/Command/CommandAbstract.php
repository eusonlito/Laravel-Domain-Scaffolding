<?php declare(strict_types=1);

namespace App\Domains\SharedApp\Command;

use App\Domains\Shared\Command\CommandAbstract as CommandAbstractShared;

abstract class CommandAbstract extends CommandAbstractShared
{
    /**
     * @return self
     */
    public function __construct()
    {
        parent::__construct();

        $this->setup();
    }

    /**
     * @return void
     */
    protected function setup(): void
    {
        $this->factory('Configuration')->action()->request();
        $this->factory('Language')->action()->request();
    }
}
