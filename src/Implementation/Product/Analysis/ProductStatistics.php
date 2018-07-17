<?php declare(strict_types=1);


namespace Dixons\Implementation\Product\Analysis;


use Dixons\Application\Product\Analysis\IProductStatistics;
use Dixons\Implementation\Persistence\IMySQLDriver;

final class ProductStatistics implements IProductStatistics
{

    /** @var IMySQLDriver */
    private $driver;

    public function __construct(IMySQLDriver $driver)
    {
        $this->driver = $driver;
    }

    /**
     * @inheritdoc
     */
    public function increaseRequestCountFor(string $id): void
    {
        $this->driver->increaseRequestCount($id);
    }

}