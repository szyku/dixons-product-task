<?php declare(strict_types=1);


namespace Dixons\Implementation\CommandBus;


use Dixons\Application\CommandBus\Exception\HandlerAlreadyRegisteredException;
use Dixons\Application\CommandBus\Exception\NoHandlerFoundException;
use Dixons\Application\CommandBus\ICommandBus;
use Psr\Log\LoggerInterface;

final class CommandBusLoggerDecorator implements ICommandBus
{
    /** @var ICommandBus */
    private $inner;
    /** @var LoggerInterface */
    private $logger;

    public function __construct(ICommandBus $inner, LoggerInterface $logger)
    {
        $this->inner = $inner;
        $this->logger = $logger;
    }

    /**
     * @inheritdoc
     */
    public function registerHandler(string $commandFQCN, object $handler): void
    {
        try {
            $this->inner->registerHandler($commandFQCN, $handler);
        } catch (HandlerAlreadyRegisteredException $e) {
            $this->logger->error(
                "Attempted to register handler twice on {$commandFQCN}. Probably the bus is wrongly configured."
            );
            throw $e;
        }
    }

    /**
     * @inheritdoc
     */
    public function handle(object $command): void
    {
        try {
            $this->inner->handle($command);
        } catch (NoHandlerFoundException $e) {
            $rf = new \ReflectionClass($command);
            $this->logger->error(
                "Attempted to execute command {$rf->getName()}, but nothing handled it."
            );
            throw $e;
        }
    }
}