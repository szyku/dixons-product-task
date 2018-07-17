<?php declare(strict_types=1);

namespace spec\Dixons\Implementation\Product\Analysis;

use Dixons\Application\Product\Analysis\IProductStatistics;
use Dixons\Implementation\Persistence\IMySQLDriver;
use Dixons\Implementation\Product\Analysis\ProductStatistics;
use PhpSpec\ObjectBehavior;

class ProductStatisticsSpec extends ObjectBehavior
{
    public function let(IMySQLDriver $driver)
    {
        $this->beConstructedWith($driver);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(ProductStatistics::class);
        $this->shouldImplement(IProductStatistics::class);
    }

    public function it_increases_the_request_count_of_a_product(IMySQLDriver $driver)
    {
        $driver->increaseRequestCount("123")->shouldBeCalledTimes(1);
        $this->increaseRequestCountFor("123");
    }
}
