<?php declare(strict_types=1);


namespace Dixons\Http\Action;


use Dixons\Application\Product\Query\IProductQuery;
use Symfony\Component\Serializer\SerializerInterface;

abstract class BaseProductAction
{
    /** @var IProductQuery */
    protected $productQuery;

    /** @var SerializerInterface */
    protected $serializer;

    public function __construct(IProductQuery $productQuery, SerializerInterface $serializer)
    {
        $this->productQuery = $productQuery;
        $this->serializer = $serializer;
    }

}