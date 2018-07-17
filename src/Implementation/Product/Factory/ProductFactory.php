<?php declare(strict_types=1);


namespace Dixons\Implementation\Product\Factory;


use Dixons\Application\Assertion\Assert;
use Dixons\Application\Product\Query\ConfidentialProductView;
use Dixons\Application\Product\Query\DetailedProductView;
use Dixons\Implementation\Persistence\Source;

final class ProductFactory implements IProductFactory
{

    public function createDetailedProduct(array $data, string $source): DetailedProductView
    {
        Assert::true(Source::exists($source));

        switch ($source) {
            case Source::MYSQL:
                return new DetailedProductView($data['id'], $data['title'] ?? "");
            case Source::ELASTIC_SEARCH:
                return new DetailedProductView($data['_id'], $data['title'] ?? "");
            default:
                throw new \RuntimeException("Definitely something wrong");
        }
    }

    public function createConfidentialProduct(array $data, string $source): ConfidentialProductView
    {
        Assert::true(Source::exists($source));

        switch ($source) {
            case Source::MYSQL:
                return new ConfidentialProductView(
                    $data['id'],
                    $data['title'] ?? "",
                    $data['request_count'] ?? 0
                );
            case Source::ELASTIC_SEARCH:
                return new ConfidentialProductView(
                    $data['_id'],
                    $data['title'] ?? "",
                    $data['requestCount'] ?? 0
                );
            default:
                throw new \RuntimeException("Definitely something wrong");
        }
    }
}