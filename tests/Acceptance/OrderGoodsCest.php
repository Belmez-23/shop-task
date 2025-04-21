<?php

declare(strict_types=1);


namespace App\Tests\Acceptance;

use App\Tests\Resources\Faker\FakerTrait;
use App\Tests\Support\AcceptanceTester;

final class OrderGoodsCest
{
    use FakerTrait;

    public function _before(AcceptanceTester $I): void
    {
        $this->loadFaker();
    }

    public function orderOneProduct(AcceptanceTester $I): void
    {
        $I->sendPostAsJson('/api/order', [
            'userId' => 1,
            'goods' => [
                [
                    'id' => 1,
                    'count' => 1,
                ],
            ],
        ]);
        $I->seeResponseCodeIs(201);
        $I->seeResponseIsValidOnJsonSchemaString(json_encode([
            'properties' => [
                'id' => [
                    'type' => 'integer',
                ],
            ],
        ]));
    }

    public function orderMultipleProducts(AcceptanceTester $I): void
    {
        $I->sendPostAsJson('/api/order', [
            'userId' => 1,
            'goods' => [
                [
                    'id' => 1,
                    'count' => 3,
                ],
                [
                    'id' => 2,
                    'count' => 2,
                ],
                [
                    'id' => 3,
                    'count' => 1,
                ],
            ],
        ]);
        $I->seeResponseCodeIs(201);
        $I->seeResponseIsValidOnJsonSchemaString(json_encode([
            'properties' => [
                'id' => [
                    'type' => 'integer',
                ],
            ],
        ]));
    }
}
