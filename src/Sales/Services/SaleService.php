<?php

namespace Sales\Services;

use Sales\Entities\Sale;
use Sales\Repositories\SaleRepository;
use Doctrine\ORM\EntityManagerInterface;

class SaleService
{
    private $saleRepository;
    private $entityManager;

    public function __construct(SaleRepository $saleRepository, EntityManagerInterface $entityManager)
    {
        $this->saleRepository = $saleRepository;
        $this->entityManager = $entityManager;
    }

    public function findAll()
    {
        return $this->saleRepository->findAll();
    }

    public function find(int $id)
    {
        return $this->saleRepository->find($id);
    }

    public function save(Sale $sale)
    {
        $this->entityManager->persist($sale);
        $this->entityManager->flush();
        return $sale;
    }

    public function remove(Sale $sale)
    {
        $this->entityManager->remove($sale);
        $this->entityManager->flush();
        return $sale;
    }
}
