<?php declare(strict_types=1);

namespace Dixons\Implementation\Persistence;

use Dixons\Implementation\Persistence\Exception\ResourceNotFoundException;

interface IElasticSearchDriver
{
    /**
     * @param string $id
     * @return array
     * @throws ResourceNotFoundException
     */
    public function findById(string $id): array;
}