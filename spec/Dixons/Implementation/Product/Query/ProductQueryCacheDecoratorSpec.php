<?php declare(strict_types=1);

namespace spec\Dixons\Implementation\Product\Query;

use Dixons\Application\Assertion\AssertionException;
use Dixons\Application\Product\Query\ConfidentialProductView;
use Dixons\Application\Product\Query\DetailedProductView;
use Dixons\Application\Product\Query\IProductQuery;
use Dixons\Implementation\Product\Query\ProductQueryCacheDecorator;
use Dixons\Implementation\Time\Duration;
use Dixons\Implementation\Time\IClock;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Psr\Cache\CacheItemInterface;
use Psr\Cache\CacheItemPoolInterface;

class ProductQueryCacheDecoratorSpec extends ObjectBehavior
{
    private const DUMMY_ID = '123';

    private const NEGATIVE_TTL = -13;

    public function let(IProductQuery $inner, CacheItemPoolInterface $cache, IClock $clock)
    {
        $this->beConstructedWith($inner, $cache, $clock);
    }

    public function it_cannot_have_negative_ttl(IProductQuery $inner, CacheItemPoolInterface $cache, IClock $clock)
    {
        $this->shouldThrow(AssertionException::class)->during('__construct', [$inner, $cache, $clock, self::NEGATIVE_TTL]);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(ProductQueryCacheDecorator::class);
        $this->shouldImplement(IProductQuery::class);
    }

    public function it_returns_detailed_product_view_on_cache_hit(CacheItemPoolInterface $cache, CacheItemInterface $item)
    {
        $dummy = new DetailedProductView(self::DUMMY_ID, 'title');
        $item->isHit()->willReturn(true);
        $item->get()->willReturn($dummy);
        $cache->getItem(Argument::containingString(self::DUMMY_ID))->willReturn($item);

        $this->getDetailedProductById(self::DUMMY_ID)->shouldReturn($dummy);
    }

    public function it_returns_detailed_product_view_on_cache_miss(
        CacheItemPoolInterface $cache,
        CacheItemInterface $item,
        IProductQuery $inner,
        IClock $clock
    )
    {
        $dummy = new DetailedProductView(self::DUMMY_ID, 'title');
        $dummyTime = new \DateTimeImmutable("+60 seconds");

        $clock->timeShiftedBy(Argument::type(Duration::class))->willReturn($dummyTime);
        $cache->getItem(Argument::containingString(self::DUMMY_ID))->willReturn($item);
        $item->isHit()->willReturn(false);
        $item->get()->shouldNotBeCalled();
        $inner->getDetailedProductById(self::DUMMY_ID)->willReturn($dummy);
        $item->set($dummy)->shouldBeCalled();
        $item->expiresAt($dummyTime)->shouldBeCalled();
        $cache->save($item)->shouldBeCalled();

        $this->getDetailedProductById(self::DUMMY_ID)->shouldReturn($dummy);
    }

    public function it_returns_confidential_product_view_on_cache_hit(CacheItemPoolInterface $cache, CacheItemInterface $item)
    {
        $dummy = new ConfidentialProductView(self::DUMMY_ID, 'title', 0);
        $item->isHit()->willReturn(true);
        $item->get()->willReturn($dummy);
        $cache->getItem(Argument::containingString(self::DUMMY_ID))->willReturn($item);

        $this->getConfidentialProductById(self::DUMMY_ID)->shouldReturn($dummy);
    }

    public function it_returns_confidential_product_view_on_cache_miss(
        CacheItemPoolInterface $cache,
        CacheItemInterface $item,
        IProductQuery $inner,
        IClock $clock
    )
    {
        $dummy = new ConfidentialProductView(self::DUMMY_ID, 'title', 0);
        $dummyTime = new \DateTimeImmutable("+60 seconds");

        $clock->timeShiftedBy(Argument::type(Duration::class))->willReturn($dummyTime);
        $cache->getItem(Argument::containingString(self::DUMMY_ID))->willReturn($item);
        $item->isHit()->willReturn(false);
        $item->get()->shouldNotBeCalled();
        $inner->getConfidentialProductById(self::DUMMY_ID)->willReturn($dummy);
        $item->set($dummy)->shouldBeCalled();
        $item->expiresAt($dummyTime)->shouldBeCalled();
        $cache->save($item)->shouldBeCalled();

        $this->getConfidentialProductById(self::DUMMY_ID)->shouldReturn($dummy);
    }
}
