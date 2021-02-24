<?php declare(strict_types=1);

namespace App\Domains\Text\Seeder;

use App\Domains\Text\Model\Text as Model;
use App\Domains\Shared\Seeder\SeederAbstract;

class Text extends SeederAbstract
{
    /**
     * @return void
     */
    public function run()
    {
        $this->truncate('text');

        Model::insert($this->json('text'));
    }
}
