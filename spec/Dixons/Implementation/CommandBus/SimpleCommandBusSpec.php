<?php declare(strict_types=1);

namespace spec\Dixons\Implementation\CommandBus;

use Dixons\Application\CommandBus\Exception\HandlerAlreadyRegisteredException;
use Dixons\Application\CommandBus\Exception\NoHandlerFoundException;
use Dixons\Application\CommandBus\ICommandBus;
use Dixons\Implementation\CommandBus\SimpleCommandBus;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class SimpleCommandBusSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(SimpleCommandBus::class);
        $this->shouldImplement(ICommandBus::class);
    }

    public function it_throws_exception_on_registering_the_same_handler_twice()
    {
        $dummy = new class { public function handle(object $object){}};

        $this->registerHandler('String', $dummy);
        $this->shouldThrow(HandlerAlreadyRegisteredException::class)->during('registerHandler', ['String', $dummy]);
    }

    public function it_throws_exception_on_executing_a_command_with_no_handler()
    {
        $this->shouldThrow(NoHandlerFoundException::class)->during('handle', [new \stdClass()]);
    }

    public function it_executes_a_handler()
    {
        $handler = new class { public function handle(object $object) {}};
        $cmd = new class {};

        $rf = new \ReflectionClass($cmd);
        $FQCN = $rf->getName();

        $this->registerHandler($FQCN, $handler);
        $this->handle($cmd);
    }
}
