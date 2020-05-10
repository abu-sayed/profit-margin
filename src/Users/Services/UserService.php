<?php

namespace Users\Services;

use Users\Entities\User;
use Users\Repositories\UserRepository;
use Doctrine\ORM\EntityManagerInterface;

class UserService
{
    private $userRepository;
    private $entityManager;

    public function __construct(UserRepository $userRepository, EntityManagerInterface $entityManager)
    {
        $this->userRepository = $userRepository;
        $this->entityManager = $entityManager;
    }

    public function findAll()
    {
        return $this->userRepository->findAll();
    }

    public function find(int $id)
    {
        return $this->userRepository->find($id);
    }

    public function save(User $user)
    {
        $this->entityManager->persist($user);
        $this->entityManager->flush();
        return $user;
    }

    public function remove(User $user)
    {
        $this->entityManager->remove($user);
        $this->entityManager->flush();
        return $user;
    }
}
