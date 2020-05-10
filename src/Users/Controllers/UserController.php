<?php

namespace Users\Controllers;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Serializer\Exception\NotEncodableValueException;
use Symfony\Component\Serializer\SerializerInterface;
use Users\Services\UserService;
use Users\Entities\User;
use Application\Services\ErrorMessageService;

/**
 * @Route("/api/users")
 */
class UserController extends AbstractController
{

    private $userService;
    private $validator;
    private $serializer;

    public function __construct(UserService $userService, ValidatorInterface $validator, SerializerInterface $serializer)
    {
        $this->userService = $userService;
        $this->validator      = $validator;
        $this->serializer     =  $serializer;
    }

    /**
     * @Route("/", name="user_list", methods={"GET"})
     */
    public function findAll()
    {
        $users = $this->userService->findAll();
        return $this->json($users);
    }

    /**
     * @Route("/{id}", name="user_get", methods={"GET"})
     */
    public function find(int $id)
    {
        $user = $this->userService->find($id);
        return $this->json($user);
    }

    /**
     * @Route("", name="user_create", methods={"POST"})
     */
    public function create(Request $request)
    {
        return $this->save($request);
    }

    /**
     * @Route("/{id}", name="user_update", methods={"PUT"})
     */
    public function update(User $user, Request $request)
    {
        return $this->save($request);
    }

    /**
     * @Route("/{id}", name="user_delete", methods={"DELETE"})
     */
    public function remove(User $user)
    {
        $user = $this->userService->remove($user);
        return $this->json($user);
    }
    
    private function save (Request $request)
    {
        try {
            $user = $this->serializer->deserialize($request->getContent(), User::class, 'json');
            $errors  = $this->validator->validate($user);
            if (count($errors) > 0) {
                return $this->json($errors, 400);
            }
            $user = $this->userService->save($user);
            return $this->json($user);
        } catch (NotEncodableValueException $exception) {
            return $this->json($exception->getMessage(), 400);
        } catch (\Exception $exception) {
            return $this->json(ErrorMessageService::getInternalServerErrorMessage($exception), 500);
        }
    }
}
