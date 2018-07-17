<?php declare(strict_types=1);

namespace spec\Dixons\Implementation\Persistence;

use Dixons\Application\Assertion\AssertionException;
use Dixons\Implementation\Persistence\EchoMockedElasticSearchDriver;
use Dixons\Implementation\Persistence\IElasticSearchDriver;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class EchoMockedElasticSearchDriverSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(EchoMockedElasticSearchDriver::class);
        $this->shouldImplement(IElasticSearchDriver::class);
    }

    public function it_does_not_accept_empty_strings_as_id()
    {
        $this->shouldThrow(AssertionException::class)->during('findById', [""]);
    }

    public function it_returns_always_dummy_data()
    {
        $result = $this->findById("123");
        $result->shouldBeArray();
        $result->shouldNotHaveCount(0);

        $result = $this->findById("122");
        $result->shouldBeArray();
        $result->shouldNotHaveCount(0);

        $result = $this->findById("111");
        $result->shouldBeArray();
        $result->shouldNotHaveCount(0);
    }
}
