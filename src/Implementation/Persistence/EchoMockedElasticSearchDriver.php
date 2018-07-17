<?php declare(strict_types=1);


namespace Dixons\Implementation\Persistence;


use Dixons\Application\Assertion\Assert;

final class EchoMockedElasticSearchDriver implements IElasticSearchDriver
{

    /**
     * Returns an array with dummy data based on the passed ID.
     * @param string $id
     * @return array
     */
    public function findById(string $id): array
    {
        Assert::isNotEmpty($id, "ID cannot be empty string.");

        return [
            '_id' => $id,
            'title' => "Title -> $id",
            'requestCount' => 123,
        ];
    }
}