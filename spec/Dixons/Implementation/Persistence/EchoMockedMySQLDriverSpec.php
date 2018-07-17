<?php declare(strict_types=1);

namespace spec\Dixons\Implementation\Persistence;

use Dixons\Application\Assertion\AssertionException;
use Dixons\Implementation\Persistence\EchoMockedMySQLDriver;
use Dixons\Implementation\Persistence\IMySQLDriver;
use PhpSpec\ObjectBehavior;

class EchoMockedMySQLDriverSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(EchoMockedMySQLDriver::class);
        $this->shouldImplement(IMySQLDriver::class);
    }

    public function it_does_not_accept_empty_strings_as_id_on_product_search()
    {
        $this->shouldThrow(AssertionException::class)->during('findProduct', [""]);
    }

    public function it_returns_always_dummy_data_based_on_id()
    {
        $result = $this->findProduct("123");
        $result->shouldBeArray();
        $result->shouldNotHaveCount(0);

        $result = $this->findProduct("122");
        $result->shouldBeArray();
        $result->shouldNotHaveCount(0);

        $result = $this->findProduct("111");
        $result->shouldBeArray();
        $result->shouldNotHaveCount(0);
    }
}
