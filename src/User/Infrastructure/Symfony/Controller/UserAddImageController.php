<?php

namespace App\User\Infrastructure\Symfony\Controller;

use App\Shared\Infrastructure\Symfony\Controller\AbstractApiController;
use App\User\Application\Command\UploadImage\UploadImageCommand;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Attributes as OA;

class UserAddImageController extends AbstractApiController
{
    #[OA\Tag('User')]
    #[Route('/users/add-image/{id}', methods: ['POST'])]
    public function __invoke(Request $request)
    {
        try {
            $uploadedFile = $request->files->get('file');
            $userId = $request->get('id');
            $name = $request->get('name');

            if (count($uploadedFile) > 4) {
                return $this->badRequest('The max amount of file to upload is 4');
            }

            $fileUrl = $this->handleMessage(
                new UploadImageCommand($uploadedFile, $userId, $name)
            );

            return $this->success(['urls' => $fileUrl]);
        } catch (\Exception $e) {
            return $this->badRequest($e->getMessage());
        }
    }
}
