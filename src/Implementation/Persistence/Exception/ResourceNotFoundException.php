<?php declare(strict_types=1);


namespace Dixons\Implementation\Persistence\Exception;


final class ResourceNotFoundException extends \RuntimeException implements IPersistenceException
{
    public function __construct(string $message = "", \Throwable $previous = null)
    {
        parent::__construct($message, 0, $previous);
    }
}