<?php

namespace Products\Controllers;

use Products\Entities\Product;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Products\Services\ProductService;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/products")
 */
class ProductController extends AbstractController
{

    private $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
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
        $requestParams = json_decode($request->getContent(), true);
        $product = new Product();
        $product->setName($requestParams['name']);
        $product = $this->productService->save($product);
        return $this->json($product);
    }

    /**
     * @Route("/{id}", name="product_update", methods={"PUT"})
     */
    public function update(Product $product, Request $request)
    {
        $requestParams = json_decode($request->getContent(), true);
        $product->setName($requestParams['name']);
        $product = $this->productService->save($product);
        return $this->json($product);
    }

    /**
     * @Route("/{id}", name="product_delete", methods={"DELETE"})
     */
    public function remove(Product $product)
    {
        $product = $this->productService->remove($product);
        return $this->json($product);
    }
}
