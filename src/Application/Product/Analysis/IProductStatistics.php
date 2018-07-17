<?php declare(strict_types=1);


namespace Dixons\Application\Product\Analysis;


use Dixons\Application\Exception\NotFoundException;

interface IProductStatistics
{
    /**
     * @param string $id
     * @throws NotFoundException When an object with $id cannot be found.
     */
    public function increaseRequestCountFor(string $id): void;
}