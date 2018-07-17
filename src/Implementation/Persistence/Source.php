<?php declare(strict_types=1);


namespace Dixons\Implementation\Persistence;


final class Source
{
    public const MYSQL = 'mysql';
    public const ELASTIC_SEARCH = 'elastic';

    public static function exists(string $value): bool
    {
        $rf = new \ReflectionClass(self::class);
        
        return in_array($value, $rf->getConstants());
    }
}