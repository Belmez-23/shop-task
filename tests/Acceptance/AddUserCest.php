<?php

declare(strict_types=1);


namespace App\Tests\Acceptance;

use App\Tests\Resources\Faker\FakerTrait;
use App\Tests\Support\AcceptanceTester;

final class AddUserCest
{
    use FakerTrait;

    public function _before(AcceptanceTester $I): void
    {
        $this->loadFaker();
    }

    public function successAdd(AcceptanceTester $I): void
    {
        $firstName = $this->faker->firstName();
        $lastName = $this->faker->lastName();

        $I->sendPostAsJson('/api/user', [
            'firstName' => $firstName,
            'lastName' => $lastName,
        ]);

        $I->seeResponseCodeIs(201);
        $I->seeResponseContainsJson([
            'firstName' => $firstName,
            'lastName' => $lastName,
        ]);
    }

    public function failAddInvalidJson(AcceptanceTester $I): void
    {
        $firstName = $this->faker->firstName();
        $lastName = '';

        $I->sendPostAsJson('/api/user', [
            'firstName' => $firstName,
            'lastName' => $lastName,
        ]);

        $I->seeResponseCodeIs(400);
    }
}
