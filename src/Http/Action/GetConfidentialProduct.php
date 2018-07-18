<?php declare(strict_types=1);


namespace Dixons\Http\Action;


use Dixons\Application\Assertion\Assert;
use Dixons\Application\Exception\NotFoundException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class GetConfidentialProduct extends BaseProductAction
{

    public function __invoke(Request $request)
    {
        $id = $request->get('id');
        Assert::notNull($id); // Configuration shouldn't allow such thing

        try {
            $product = $this->productQuery->getConfidentialProductById($id);
        } catch (NotFoundException $e) {
            return Response::create("", Response::HTTP_NOT_FOUND);
        }

        $serialized = $this->serializer->serialize($product, 'json');

        return JsonResponse::fromJsonString($serialized);
    }

}