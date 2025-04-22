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

        // ✔ OrderGoodsCest: Order one product (0.02s)
    }

    public function orderMultipleProducts(AcceptanceTester $I): void
    {
        $I->sendPostAsJson('/api/order', [
            'userId' => 1,
            'goods' => [
                [
                    'id' => $this->faker->numberBetween(1, 10),
                    'count' => $this->faker->numberBetween(1, 10),
                ],
                [
                    'id' => $this->faker->numberBetween(1, 10),
                    'count' => $this->faker->numberBetween(1, 10),
                ],
                [
                    'id' => $this->faker->numberBetween(1, 10),
                    'count' => $this->faker->numberBetween(1, 10),
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

        // ✔ OrderGoodsCest: Order multiple products (0.03s)
    }

    public function orderMultipleProductsManyTimes(AcceptanceTester $I): void
    {
        $times = $this->faker->numberBetween(10, 50);

        for ($i = 0; $i <= $times; $i++) {
            $this->orderMultipleProducts($I);
        }

        // ✔ OrderGoodsCest: Order multiple products many times (1.11s)
    }

    public function order100Goods(AcceptanceTester $I): void
    {
        $body = [
            'userId' => 1,
        ];

        for ($i = 1; $i <= 100; $i++) {
            $body['goods'][] = [
                'id' => $i,
                'count' => $this->faker->numberBetween(1, 100),
            ];
        }

        $I->sendPostAsJson('/api/order', $body);
        $I->seeResponseCodeIs(201);
        $I->seeResponseIsValidOnJsonSchemaString(json_encode([
            'properties' => [
                'id' => [
                    'type' => 'integer',
                ],
            ],
        ]));

        // ✔ OrderGoodsCest: Order100 goods (0.07s)
    }
}
