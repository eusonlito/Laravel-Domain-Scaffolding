<?php declare(strict_types=1);

namespace App\Domains\UserPasswordReset\Test\Feature;

use App\Domains\Shared\Test\Feature\FeatureAbstract as FeatureAbstractShared;
use App\Domains\UserPasswordReset\Model\UserPasswordReset as Model;

abstract class FeatureAbstract extends FeatureAbstractShared
{
    /**
     * @return \App\Domains\UserPasswordReset\Model\UserPasswordReset
     */
    protected function row(): Model
    {
        return Model::orderBy('id', 'ASC')->first() ?: Model::factory()->create();
    }
}
