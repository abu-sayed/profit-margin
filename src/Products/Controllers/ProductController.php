<?php

namespace Products\Controllers;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Serializer\Exception\NotEncodableValueException;
use Symfony\Component\Serializer\SerializerInterface;
use Products\Services\ProductService;
use Products\Entities\Product;
use Application\Services\ErrorMessageService;

/**
 * @Route("/api/products")
 */
class ProductController extends AbstractController
{

    private $productService;
    private $validator;
    private $serializer;

    public function __construct(ProductService $productService, ValidatorInterface $validator, SerializerInterface $serializer)
    {
        $this->productService = $productService;
        $this->validator      = $validator;
        $this->serializer     =  $serializer;
    }

    /**
     * @Route("/", name="product_list", methods={"GET"})
     */
    public function findAll()
    {
        $products = $this->productService->findAll();
        return $this->json($products);
    }

    /**
     * @Route("/{id}", name="product_get", methods={"GET"})
     */
    public function find(int $id)
    {
        $product = $this->productService->find($id);
        return $this->json($product);
    }

    /**
     * @Route("", name="product_create", methods={"POST"})
     */
    public function create(Request $request)
    {
        return $this->save($request);
    }

    /**
     * @Route("/{id}", name="product_update", methods={"PUT"})
     */
    public function update(Product $product, Request $request)
    {
        return $this->save($request);
    }

    /**
     * @Route("/{id}", name="product_delete", methods={"DELETE"})
     */
    public function remove(Product $product)
    {
        $product = $this->productService->remove($product);
        return $this->json($product);
    }
    
    private function save (Request $request)
    {
        try {
            $product = $this->serializer->deserialize($request->getContent(), Product::class, 'json');
            $errors  = $this->validator->validate($product);
            if (count($errors) > 0) {
                return $this->json($errors, 400);
            }
            $product = $this->productService->save($product);
            return $this->json($product);
        } catch (NotEncodableValueException $exception) {
            return $this->json($exception->getMessage(), 400);
        } catch (\Exception $exception) {
            return $this->json(ErrorMessageService::getInternalServerErrorMessage($exception), 500);
        }
    }
}
