<?php declare(strict_types=1);


namespace Dixons\Application\CommandBus\Exception;


final class HandlerAlreadyRegisteredException extends \RuntimeException implements ICommandBusException
{
    public function __construct(string $FQCN)
    {
        $this->message = sprintf("A handler for %s already exists", $FQCN);
    }

}