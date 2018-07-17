<?php declare(strict_types=1);

namespace Dixons\Application\Product\Query;


use Dixons\Application\Exception\NotFoundException;

interface IProductQuery
{
    /**
     * @param string $id
     * @return DetailedProductView
     * @throws NotFoundException
     */
    public function getDetailedProductById(string $id): DetailedProductView;

    /**
     * @param string $id
     * @return ConfidentialProductView
     * @throws NotFoundException
     */
    public function getConfidentialProductById(string $id): ConfidentialProductView;
}