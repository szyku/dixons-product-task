<?php declare(strict_types=1);


namespace Dixons\Implementation\CommandBus;


use Dixons\Application\Assertion\Assert;
use Dixons\Application\CommandBus\Exception\HandlerAlreadyRegisteredException;
use Dixons\Application\CommandBus\Exception\NoHandlerFoundException;
use Dixons\Application\CommandBus\ICommandBus;

final class SimpleCommandBus implements ICommandBus
{

    /** @var array */
    private $handlers = [];

    /**
     * @inheritdoc
     */
    public function registerHandler(string $commandFQCN, object $handler): void
    {
        if (array_key_exists($commandFQCN, $this->handlers)) {
            throw new HandlerAlreadyRegisteredException("There's already a handler for $commandFQCN");
        }

        Assert::hasMethod($handler, 'handle');

        $this->handlers[$commandFQCN] = $handler;
    }

    /**
     * @inheritdoc
     */
    public function handle(object $command): void
    {
        $rf = new \ReflectionClass($command);
        $FQCN = $rf->getName();

        if (!array_key_exists($FQCN, $this->handlers)) {
            throw new NoHandlerFoundException("There's no handler to execute command for $FQCN");
        }

        $this->handlers[$FQCN]->handle($command);
    }
}