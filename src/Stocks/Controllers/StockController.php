<?php

namespace Stocks\Controllers;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Serializer\Exception\NotEncodableValueException;
use Symfony\Component\Serializer\SerializerInterface;
use Stocks\Services\StockService;
use Stocks\Entities\Stock;
use Application\Services\ErrorMessageService;

/**
 * @Route("/api/stocks")
 */
class StockController extends AbstractController
{

    private $stockService;
    private $validator;
    private $serializer;

    public function __construct(StockService $stockService, ValidatorInterface $validator, SerializerInterface $serializer)
    {
        $this->stockService = $stockService;
        $this->validator   = $validator;
        $this->serializer  =  $serializer;
    }

    /**
     * @Route("/", name="sale_list", methods={"GET"})
     */
    public function findAll()
    {
        $stocks = $this->stockService->findAll();
        return $this->json($stocks);
    }

    /**
     * @Route("/{id}", name="sale_get", methods={"GET"})
     */
    public function find(int $id)
    {
        $stock = $this->stockService->find($id);
        return $this->json($stock);
    }

    /**
     * @Route("", name="sale_create", methods={"POST"})
     */
    public function create(Request $request)
    {
        return $this->save($request);
    }

    /**
     * @Route("/{id}", name="product_update", methods={"PUT"})
     */
    public function update(Stock $stock, Request $request)
    {
        return $this->save($request);
    }

    /**
     * @Route("/{id}", name="product_delete", methods={"DELETE"})
     */
    public function remove(Stock $stock)
    {
        $stock = $this->stockService->remove($stock);
        return $this->json($stock);
    }
    
    private function save (Request $request)
    {
        try {
            $stock = $this->serializer->deserialize($request->getContent(), Stock::class, 'json');
            $errors  = $this->validator->validate($stock);
            if (count($errors) > 0) {
                return $this->json($errors, 400);
            }
            $stock = $this->stockService->save($stock);
            return $this->json($stock);
        } catch (NotEncodableValueException $exception) {
            return $this->json($exception->getMessage(), 400);
        } catch (\Exception $exception) {
            return $this->json(ErrorMessageService::getInternalServerErrorMessage($exception), 500);
        }
    }
}
