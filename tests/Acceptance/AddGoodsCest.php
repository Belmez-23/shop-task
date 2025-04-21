<?php

declare(strict_types=1);


namespace App\Tests\Acceptance;

use App\Tests\Resources\Faker\FakerTrait;
use App\Tests\Support\AcceptanceTester;
use Symfony\Component\HttpFoundation\Response;

final class AddGoodsCest
{
    use FakerTrait;

    public function _before(AcceptanceTester $I): void
    {
        $this->loadFaker();
    }

    public function successAdd(AcceptanceTester $I): void
    {
        $title = $this->faker->word();
        $price = $this->faker->randomFloat();
        $count = $this->faker->numberBetween(1, 100);

        $I->sendPostAsJson('/api/goods', [
            'title' => $title,
            'price' => $price,
            'count' => $count,
        ]);

        $I->seeResponseCodeIs(Response::HTTP_CREATED);
        $I->seeResponseContainsJson([
            'title' => $title,
            'price' => $price,
            'count' => $count,
        ]);
    }

    public function failAdd(AcceptanceTester $I): void
    {
        $title = $this->faker->word();
        $price = $this->faker->randomFloat();
        $count = -8;

        $I->sendPostAsJson('/api/goods', [
            'title' => $title,
            'price' => $price,
            'count' => $count,
        ]);

        $I->seeResponseCodeIs(Response::HTTP_BAD_REQUEST);
    }
}
