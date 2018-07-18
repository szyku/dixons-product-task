<?php declare(strict_types=1);


namespace Dixons\Http\Action;


use Dixons\Application\Assertion\Assert;
use Dixons\Application\CommandBus\Exception\NoHandlerFoundException;
use Dixons\Application\CommandBus\ICommandBus;
use Dixons\Application\Exception\NotFoundException;
use Dixons\Application\Product\Command\IncreaseRequestCount;
use Dixons\Application\Product\Query\IProductQuery;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;

final class GetDetailedProduct extends BaseProductAction
{
    /** @var ICommandBus */
    private $bus;

    /** @var LoggerInterface */
    private $logger;

    public function __construct(IProductQuery $productQuery, SerializerInterface $serializer, ICommandBus $commandBus, LoggerInterface $logger)
    {
        $this->bus = $commandBus;
        $this->logger = $logger;
        parent::__construct($productQuery, $serializer);
    }


    public function __invoke(Request $request)
    {
        $id = $request->get('id');
        Assert::notNull($id);

        $increaseCount = new IncreaseRequestCount($id);

        try {
            $this->bus->handle($increaseCount);
        } catch (NoHandlerFoundException $e) {
            $this->logger->error("Couldn't increase view count for product with ID #$id");
        }

        try {
            $product = $this->productQuery->getDetailedProductById($id);
        } catch (NotFoundException $e) {
            return Response::create("", Response::HTTP_NOT_FOUND);
        }

        $serialized = $this->serializer->serialize($product, 'json');

        return JsonResponse::fromJsonString($serialized);
    }


}