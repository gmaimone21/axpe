<?php

namespace App\User\Infrastructure\Symfony\Controller;

use App\Shared\Infrastructure\Symfony\Controller\AbstractApiController;
use App\User\Domain\Exception\ValidationException;
use App\User\Infrastructure\Symfony\Http\UserCreateForm;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Attributes as OA;

class UserCreateController extends AbstractApiController
{
    #[OA\Tag('User')]
    #[Route('/users/register', methods: ['POST'])]
    public function __invoke(Request $request)
    {
        try {
            $userCreateForm = new UserCreateForm($request);
            $id = $this->handleMessage(
                $userCreateForm->params()
            );

            return $this->success(['userId' => $id], 201);
        } catch (\Exception|ValidationException $e) {
            return $this->badRequest($e->getMessage());
        }


    }
}
