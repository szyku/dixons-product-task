<?php declare(strict_types=1);


namespace Dixons\Application\Product\Query;

/**
 * Class DetailedProductView
 * @package Dixons\Application\Product\Query
 *
 * View containing information relevant to a customer
 */
final class DetailedProductView
{
    private $id;

    private $title;

    public function __construct(string $id, string $title)
    {
        $this->id = $id;
        $this->title = $title;
    }

    public function id(): string
    {
        return $this->id;
    }

    public function title(): string
    {
        return $this->title;
    }
}