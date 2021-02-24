<?php declare(strict_types=1);

namespace App\Domains\Country\Seeder;

use App\Domains\Country\Model\Country as Model;
use App\Domains\Shared\Seeder\SeederAbstract;

class Country extends SeederAbstract
{
    /**
     * @return void
     */
    public function run()
    {
        $this->truncate('country');

        Model::insert($this->json('country'));
    }
}
