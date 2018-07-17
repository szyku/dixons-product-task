<?php declare(strict_types=1);


namespace Dixons\Implementation\Product\Query;


use Dixons\Application\Product\Query\ConfidentialProductView;
use Dixons\Application\Product\Query\DetailedProductView;
use Dixons\Application\Product\Query\IProductQuery;
use Dixons\Implementation\Persistence\Exception\ResourceNotFoundException;
use Dixons\Implementation\Persistence\IElasticSearchDriver;
use Dixons\Implementation\Persistence\IMySQLDriver;
use Dixons\Implementation\Persistence\Source;
use Dixons\Implementation\Product\Factory\IProductFactory;

final class ProductQuery implements IProductQuery
{
    /** @var IElasticSearchDriver */
    private $documentDriver;

    /** @var IMySQLDriver */
    private $sqlDriver;

    /** @var IProductFactory */
    private $factory;

    /**
     * ProductQuery constructor.
     * @param IElasticSearchDriver $documentDriver
     * @param IMySQLDriver $sqlDriver
     * @param IProductFactory $factory
     */
    public function __construct(IElasticSearchDriver $documentDriver, IMySQLDriver $sqlDriver, IProductFactory $factory)
    {
        $this->documentDriver = $documentDriver;
        $this->sqlDriver = $sqlDriver;
        $this->factory = $factory;
    }

    /**
     * @inheritdoc
     */
    public function getDetailedProductById(string $id): DetailedProductView
    {
        list($data, $source) = $this->fetchProductData($id);

        return $this->factory->createDetailedProduct($data, $source);
    }

    /**
     * @inheritdoc
     */
    public function getConfidentialProductById(string $id): ConfidentialProductView
    {
        list($data, $source) = $this->fetchProductData($id);

        return $this->factory->createConfidentialProduct($data, $source);
    }

    private function fetchProductData(string $id): array
    {
        try {
            return [$this->documentDriver->findById($id), Source::ELASTIC_SEARCH];
        } catch (ResourceNotFoundException $e) {
            return [$this->sqlDriver->getFromMysql($id), Source::MYSQL];
        }
    }

}