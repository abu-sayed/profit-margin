<?php

namespace Sales\Controllers;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Serializer\Exception\NotEncodableValueException;
use Symfony\Component\Serializer\SerializerInterface;
use Sales\Services\SaleService;
use Sales\Entities\Sale;
use Application\Services\ErrorMessageService;

/**
 * @Route("/api/sales")
 */
class SaleController extends AbstractController
{

    private $saleService;
    private $validator;
    private $serializer;

    public function __construct(SaleService $saleService, ValidatorInterface $validator, SerializerInterface $serializer)
    {
        $this->saleService = $saleService;
        $this->validator   = $validator;
        $this->serializer  =  $serializer;
    }

    /**
     * @Route("/", name="sale_list", methods={"GET"})
     */
    public function findAll()
    {
        $sales = $this->saleService->findAll();
        return $this->json($sales);
    }

    /**
     * @Route("/{id}", name="sale_get", methods={"GET"})
     */
    public function find(int $id)
    {
        $sale = $this->saleService->find($id);
        return $this->json($sale);
    }

    /**
     * @Route("", name="sale_create", methods={"POST"})
     */
    public function create(Request $request)
    {
        return $this->save($request);
    }

    /**
     * @Route("/{id}", name="sale_update", methods={"PUT"})
     */
    public function update(Sale $sale, Request $request)
    {
        return $this->save($request);
    }

    /**
     * @Route("/{id}", name="sale_delete", methods={"DELETE"})
     */
    public function remove(Sale $sale)
    {
        $sale = $this->saleService->remove($sale);
        return $this->json($sale);
    }
    
    private function save (Request $request)
    {
        try {
            $sale = $this->serializer->deserialize($request->getContent(), Sale::class, 'json');
            $errors  = $this->validator->validate($sale);
            if (count($errors) > 0) {
                return $this->json($errors, 400);
            }
            $sale = $this->saleService->save($sale);
            return $this->json($sale);
        } catch (NotEncodableValueException $exception) {
            return $this->json($exception->getMessage(), 400);
        } catch (\Exception $exception) {
            return $this->json(ErrorMessageService::getInternalServerErrorMessage($exception), 500);
        }
    }
}
