<?php declare(strict_types=1);


namespace Dixons\Implementation\Product\Query;


use Dixons\Application\Assertion\Assert;
use Dixons\Application\Product\Query\ConfidentialProductView;
use Dixons\Application\Product\Query\DetailedProductView;
use Dixons\Application\Product\Query\IProductQuery;
use Dixons\Implementation\Time\Duration;
use Dixons\Implementation\Time\IClock;
use Psr\Cache\CacheItemPoolInterface;

final class ProductQueryCacheDecorator implements IProductQuery
{
    private const DEFAULT_TTL = 60 * 60;

    /** @var IProductQuery */
    private $inner;

    /** @var CacheItemPoolInterface */
    private $cache;

    /** @var IClock */
    private $clock;

    /** @var Duration */
    private $ttlDuration;

    public function __construct(IProductQuery $inner, CacheItemPoolInterface $cache, IClock $clock, int $ttlInSeconds = self::DEFAULT_TTL)
    {
        $this->inner = $inner;
        $this->cache = $cache;
        $this->clock = $clock;
        $this->ttlDuration = Duration::inSeconds($ttlInSeconds);
        Assert::isDurationInFuture($this->ttlDuration);
    }


    /**
     * @inheritdoc
     */
    public function getDetailedProductById(string $id): DetailedProductView
    {
        $executor = function () use ($id) {
            return $this->inner->getDetailedProductById($id);
        };

        /** @var DetailedProductView $object */
        $object = $this->hitOrExecute('detailed_product_' . $id, $executor);

        return $object;
    }

    /**
     * @inheritdoc
     */
    public function getConfidentialProductById(string $id): ConfidentialProductView
    {
        $executor = function () use ($id) {
            return $this->inner->getConfidentialProductById($id);
        };

        /** @var ConfidentialProductView $object */
        $object = $this->hitOrExecute('confidential_product_' . $id, $executor);

        return $object;
    }

    private function hitOrExecute(string $cacheKey, \Closure $fetchingClosure): object
    {
        $cacheItem = $this->cache->getItem($cacheKey);

        if ($cacheItem->isHit()) {
            return $cacheItem->get();
        }

        $product = $fetchingClosure->call($this);
        $cacheItem->set($product);
        $cacheItem->expiresAt($this->clock->timeShiftedBy($this->ttlDuration));
        $this->cache->save($cacheItem);

        return $product;
    }

}