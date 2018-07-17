<?php

namespace Dixons\Implementation\Persistence;

use Dixons\Implementation\Persistence\Exception\ResourceNotFoundException;

interface IMySQLDriver
{
    /**
     * @param string $id
     * @return array
     * @throws ResourceNotFoundException
     */
    public function findProduct(string $id): array;

    /**
     * @param string $id
     * @throws ResourceNotFoundException
     */
    public function increaseRequestCount(string $id): void;
}