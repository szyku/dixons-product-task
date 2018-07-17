<?php declare(strict_types=1);

namespace Dixons\Application\CommandBus;


use Dixons\Application\CommandBus\Exception\HandlerAlreadyRegisteredException;
use Dixons\Application\CommandBus\Exception\NoHandlerFoundException;

interface ICommandBus
{
    /**
     * @param string $commandFQCN Fully qualified class name of a command.
     * @param object $handler The handler which will be bind to the command FQCN.
     * @throws HandlerAlreadyRegisteredException
     */
    public function registerHandler(string $commandFQCN, object $handler): void;

    /**
     * @param object $command The command object to be executed.
     * @throws NoHandlerFoundException If nothing could handle the command.
     */
    public function handle(object $command): void;
}