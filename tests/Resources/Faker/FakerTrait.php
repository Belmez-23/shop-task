<?php

namespace App\Tests\Resources\Faker;

use Faker\Factory;
use Faker\Generator;

trait FakerTrait
{
    private Generator $faker;

    private function loadFaker(string $locale = Factory::DEFAULT_LOCALE): void
    {
        $this->faker = Factory::create($locale);
    }
}
