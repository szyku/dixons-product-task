<?php declare(strict_types=1);


namespace Dixons\Application\Product\Command;


use Dixons\Application\Exception\NotFoundException;
use Dixons\Application\Product\Analysis\IProductStatistics;

final class IncreaseRequestCountHandler
{
    /** @var IProductStatistics */
    private $productStats;

    public function __construct(IProductStatistics $productStats)
    {
        $this->productStats = $productStats;
    }


    public function handle(IncreaseRequestCount $command): void
    {
        try {
            $this->productStats->increaseRequestCountFor($command->id());
        } catch (NotFoundException $e) {
            throw new \InvalidArgumentException("Provided product record count couldn't be increased", $e);
        }
    }
}