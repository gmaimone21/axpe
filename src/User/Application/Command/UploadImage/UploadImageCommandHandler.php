<?php

namespace App\User\Application\Command\UploadImage;

use App\Shared\Domain\Bus\HandlerInterface;
use App\User\Domain\Contracts\ImageRepositoryInterface;
use App\User\Domain\Contracts\UserRepositoryInterface;
use App\User\Domain\Model\Image;
use App\User\Domain\ValueObjects\File;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;

#[AsMessageHandler]
class UploadImageCommandHandler implements HandlerInterface
{
   public function __construct(
       private ImageRepositoryInterface $imageRepository,
       private UserRepositoryInterface $userRepository
   )
   {
   }

   public function __invoke(UploadImageCommand $command): array
   {
       $user = $this->userRepository->find($command->userId);
       if (!$user) {
           throw new ResourceNotFoundException('User not found');
       }
       $uploadedFiles = $command->uploadedFile;
       $allImages = [];

       foreach ($uploadedFiles as $key => $uploadedFile) {
           $destination = 'uploads/maimone/' . uniqid() . '.' . $uploadedFile->guessExtension();
           $imagePath = new File($uploadedFile->getRealPath());
           $image = new Image($imagePath, $user);
           $url = $this->imageRepository->upload($image, $destination);
           $image->setUrl($url);
           $image->setName($command->name[$key]);
           $allImages[] = $url;
           $user->addImage($image);
           $this->userRepository->save($user);
       }


       return $allImages;
   }
}