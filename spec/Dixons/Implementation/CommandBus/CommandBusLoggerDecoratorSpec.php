<?php declare(strict_types=1);

namespace spec\Dixons\Implementation\CommandBus;

use Dixons\Application\CommandBus\Exception\HandlerAlreadyRegisteredException;
use Dixons\Application\CommandBus\Exception\NoHandlerFoundException;
use Dixons\Application\CommandBus\ICommandBus;
use Dixons\Implementation\CommandBus\CommandBusLoggerDecorator;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Psr\Log\LoggerInterface;

class CommandBusLoggerDecoratorSpec extends ObjectBehavior
{
    public function let(ICommandBus $inner, LoggerInterface $logger)
    {
        $this->beConstructedWith($inner, $logger);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(CommandBusLoggerDecorator::class);
        $this->shouldImplement(ICommandBus::class);
    }

    public function it_does_not_log_anything_on_good_execution(LoggerInterface $logger, ICommandBus $inner)
    {
        $inner->registerHandler(Argument::type('string'), Argument::type('object'))->shouldBeCalledTimes(1);
        $logger->error(Argument::cetera())->shouldNotBeCalled();

        $this->registerHandler('string', new \stdClass());

        $inner->handle(Argument::type('object'))->shouldBeCalledTimes(1);
        $logger->error(Argument::cetera())->shouldNotBeCalled();

        $this->handle(new \stdClass());
    }

    public function it_logs_only_on_interface_exceptions(LoggerInterface $logger, ICommandBus $inner)
    {
        $ex1 = new HandlerAlreadyRegisteredException("1231");
        $inner->registerHandler(Argument::type('string'), Argument::type('object'))->willThrow($ex1);
        $logger->error(Argument::cetera())->shouldBeCalled();
        $this->shouldThrow($ex1)->duringRegisterHandler('string', new \stdClass());

        $ex2 = new NoHandlerFoundException("123123");
        $inner->handle(Argument::type('object'))->willThrow($ex2);
        $this->shouldThrow($ex2)->duringHandle(new \stdClass());
        $logger->error(Argument::cetera())->shouldBeCalled();
    }


}
