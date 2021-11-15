<?php declare(strict_types=1);

use App\Domains\Shared\Migration\MigrationAbstract;
use App\Domains\Configuration\Seeder\Configuration as ConfigurationSeeder;
use App\Domains\Country\Seeder\Country as CountrySeeder;
use App\Domains\Language\Seeder\Language as LanguageSeeder;

return new class extends MigrationAbstract
{
    /**
     * @return void
     */
    public function up()
    {
        $this->seed();
    }

    /**
     * @return void
     */
    protected function seed(): void
    {
        (new ConfigurationSeeder())->run();
        (new CountrySeeder())->run();
        (new LanguageSeeder())->run();
    }
};
