<?php declare(strict_types=1);


namespace Dixons\Implementation\Persistence;


use Dixons\Application\Assertion\Assert;
use Dixons\Implementation\Persistence\Exception\ResourceNotFoundException;

final class EchoMockedMySQLDriver implements IMySQLDriver
{

    /**
     * Returns an array with dummy data based on the passed ID.
     * @param string $id
     * @return array
     */
    public function findProduct(string $id): array
    {
        Assert::isNotEmpty($id, "ID cannot be empty string.");

        return [
            'id' => $id,
            'title' => "Title -> $id",
            'request_count' => 123,
        ];
    }

    /**
     * @param string $id
     * @throws ResourceNotFoundException
     */
    public function increaseRequestCount(string $id): void
    {
        Assert::isNotEmpty($id, "ID cannot be empty string.");

        // pretend that we update only one thing
    }
}