<?php declare(strict_types=1);


namespace Dixons\Application\Assertion;


use Dixons\Implementation\Time\Duration;

final class Assert
{
    public static function hasMethod(object $subject, string $method, string $msg = "Method is missing.")
    {
        $rf = new \ReflectionClass($subject);
        if (!$rf->hasMethod($method)) {
            throw new AssertionException($msg);
        }
    }

    public static function isNotEmpty($value, string $msg = "This value should not be empty."): void
    {
        if (empty($value)) {
            throw new AssertionException($msg);
        }
    }

    public static function isNotNegativeNumber(int $value, string $msg = "This value should not be less than 0."): void
    {
        if ($value < 0) {
            throw new AssertionException($msg);
        }
    }

    public static function isDurationInFuture(Duration $duration, string $msg = "This value should not be a duration in the past."): void
    {
        if (!$duration->isFuture()) {
            throw new AssertionException($msg);
        }
    }

    public static function firstIsLessOrEqualSecond(int $of, int $from, string $msg = "Second value is less than the first one."): void
    {
        if ($of > $from) {
            throw new AssertionException($msg);
        }
    }

    public static function isNotZero(int $value, string $msg = "The value should not be zero."): void
    {
        if ($value === 0) {
            throw new AssertionException($msg);
        }
    }

    public static function true(bool $value, string $msg = "Expression should be true."): void
    {
        if (!$value) {
            throw new AssertionException($msg);
        }
    }

}