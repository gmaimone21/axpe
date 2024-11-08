<?php

namespace App\User\Application\Command\UserCreate;

use App\Shared\Application\Service\UuidGeneratorInterface;
use App\Shared\Domain\Bus\HandlerInterface;
use App\User\Domain\Contracts\ImageRepositoryInterface;
use App\User\Domain\Contracts\PasswordHasherInterface;
use App\User\Domain\Contracts\UserRepositoryInterface;
use App\User\Domain\Model\Image;
use App\User\Domain\Model\User;
use App\User\Domain\ValueObjects\Email;
use App\User\Domain\ValueObjects\File;
use App\User\Domain\ValueObjects\FirstName;
use App\User\Domain\ValueObjects\IsActive;
use App\User\Domain\ValueObjects\LastName;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]

class UserCreateCommandHandler implements HandlerInterface
{
    public function __construct(
        private UuidGeneratorInterface $uuidGenerator,
        private UserRepositoryInterface $userRepository,
        private PasswordHasherInterface $passwordHasher,
        private ImageRepositoryInterface $imageRepository
    ) {
    }

    public function __invoke(UserCreateCommand $command): string
    {
        $exist = $this->userRepository->findUserByEmail($command->email);
        if ($exist) {
            throw new \InvalidArgumentException('The email already exist');
        }
        $id = $this->uuidGenerator->generate();
        $isActive = new IsActive($command->active);
        $user = new User(
            $id,
            new FirstName($command->firstName),
            new LastName($command->lastName),
            new Email($command->email),
            $command->password,
            $isActive->__toNumber(),
            $this->getAvatarUrl($command)
        );

        $this->passwordHasher->hashPassword($user);

        $this->userRepository->save($user);

        return $id;
    }

    private function getAvatarUrl(UserCreateCommand $command)
    {
        $avatar = $command->avatar;
        if ($avatar === null) {
            return "https://cw-recruitment-tests.s3.eu-west-1.amazonaws.com/uploads/maimone/671ad1f83e8f4.png";
        }
        $imagePath = new File($avatar->getRealPath());
        $image = new Image($imagePath, null);
        $destination = 'uploads/maimone/' . uniqid() . '.' . $avatar->guessExtension();

        return $this->imageRepository->upload($image, $destination);
    }
}