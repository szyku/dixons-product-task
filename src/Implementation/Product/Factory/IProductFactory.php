<?php declare(strict_types=1);

namespace Dixons\Implementation\Product\Factory;


use Dixons\Application\Product\Query\ConfidentialProductView;
use Dixons\Application\Product\Query\DetailedProductView;

interface IProductFactory
{
    public function createDetailedProduct(array $data, string $source): DetailedProductView;

    public function createConfidentialProduct(array $data, string $source): ConfidentialProductView;
}