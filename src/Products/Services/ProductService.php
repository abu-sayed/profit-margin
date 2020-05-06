<?php

namespace Products\Services;

use Products\Entities\Product;
use Products\Repositories\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;

class ProductService
{
    private $productRepository;
    private $entityManager;

    public function __construct(ProductRepository $productRepository, EntityManagerInterface $entityManager)
    {
        $this->productRepository = $productRepository;
        $this->entityManager = $entityManager;
    }

    public function findAll()
    {
        return $this->productRepository->findAll();
    }

    public function find(int $id)
    {
        return $this->productRepository->find($id);
    }

    public function save(Product $product)
    {
        $this->entityManager->persist($product);
        $this->entityManager->flush();
        return $product;
    }

    public function remove(Product $product)
    {
        $this->entityManager->remove($product);
        $this->entityManager->flush();
        return $product;
    }
}
