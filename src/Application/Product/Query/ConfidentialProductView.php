<?php declare(strict_types=1);


namespace Dixons\Application\Product\Query;

/**
 * Class ConfidentialProductView
 * @package Dixons\Application\Product\Query
 *
 * View containing information meant for a back-office user. For example, an admin or marketer.
 */
final class ConfidentialProductView
{

    private $id;

    private $title;

    private $requestCount;

    public function __construct(string $id, string $title, int $requestCount)
    {
        $this->id = $id;
        $this->title = $title;
        $this->requestCount = $requestCount;
    }

    public function id(): string
    {
        return $this->id;
    }

    public function title(): string
    {
        return $this->title;
    }

    public function requestCount(): int
    {
        return $this->requestCount;
    }
}