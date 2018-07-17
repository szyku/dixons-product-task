<?php declare(strict_types=1);


namespace Dixons\Application\Exception;


use Throwable;

final class NotFoundException extends \RuntimeException implements IApplicationException
{
    public function __construct(string $message = "", Throwable $previous = null)
    {
        parent::__construct($message, 0, $previous);
    }

}