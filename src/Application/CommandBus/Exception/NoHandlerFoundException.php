<?php declare(strict_types=1);


namespace Dixons\Application\CommandBus\Exception;


final class NoHandlerFoundException extends \RuntimeException implements ICommandBusException
{
    public function __construct(string $FQCN)
    {
        $this->message = sprintf("A handler for %s doesn't exist", $FQCN);
    }
}