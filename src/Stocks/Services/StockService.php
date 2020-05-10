<?php

namespace Stocks\Services;

use Stocks\Entities\Stock;
use Stocks\Repositories\StockRepository;
use Doctrine\ORM\EntityManagerInterface;

class StockService
{
    private $stockRepository;
    private $entityManager;

    public function __construct(StockRepository $stockRepository, EntityManagerInterface $entityManager)
    {
        $this->stockRepository = $stockRepository;
        $this->entityManager = $entityManager;
    }

    public function findAll()
    {
        return $this->stockRepository->findAll();
    }

    public function find(int $id)
    {
        return $this->stockRepository->find($id);
    }

    public function save(Stock $stock)
    {
        $this->entityManager->persist($stock);
        $this->entityManager->flush();
        return $stock;
    }

    public function remove(Stock $stock)
    {
        $this->entityManager->remove($stock);
        $this->entityManager->flush();
        return $stock;
    }
}
