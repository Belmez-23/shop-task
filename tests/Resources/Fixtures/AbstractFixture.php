<?php

namespace App\Tests\Resources\Fixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;

abstract class AbstractFixture extends Fixture implements FixtureGroupInterface
{
    public const GROUP = 'default';

    public static function getGroups(): array
    {
        return [self::GROUP];
    }
}
