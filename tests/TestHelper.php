<?php

namespace Tests;

use Carbon\Carbon;

class TestHelper
{
    public static function getTestString(int $length = 10): string
    {
        return substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length/strlen($x)) )),1,$length);
    }

    public static function getTestInt(int $min = 1, int $max = 100): int
    {
        return random_int($min, $max);
    }

    public static function getTestBool(): bool
    {
        return (bool) random_int(0, 1);
    }

    public static function getTestDate(): Carbon
    {
        return Carbon::today()->addDays(random_int(0, 100));
    }

    public static function getTestDateAsString(): string
    {
        return self::getTestDate()->toDateString();
    }
}
