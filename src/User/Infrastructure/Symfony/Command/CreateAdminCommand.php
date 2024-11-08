<?php

namespace App\User\Infrastructure\Symfony\Command;

use App\Shared\Application\Service\UuidGeneratorInterface;
use App\User\Domain\Contracts\PasswordHasherInterface;
use App\User\Domain\Contracts\UserRepositoryInterface;
use App\User\Domain\Model\User;
use App\User\Domain\ValueObjects\Email;
use App\User\Domain\ValueObjects\FirstName;
use App\User\Domain\ValueObjects\IsActive;
use App\User\Domain\ValueObjects\LastName;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'app:user:create_admin')]
class CreateAdminCommand extends Command
{
    public function __construct(
        private UuidGeneratorInterface $uuidGenerator,
        private UserRepositoryInterface $userRepository,
        private PasswordHasherInterface $passwordHasher
    ) {
        parent::__construct(null);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $identifier = $this->uuidGenerator->generate();
        $user = new User(
            $identifier,
            new FirstName('Gustavo'),
            new LastName('Maimone'),
            new Email('gmaimone21'.random_int(0,9).'@gmail.com'),
            'admin12',
            new IsActive(true),
            'www.avatar3.com'
        );
        $this->passwordHasher->hashPassword($user);

        $this->userRepository->save($user);

        return Command::SUCCESS;
    }
}

/*
 * string $id,
        string $firstName,
        string $lastName,
        string $email,
        string $plainPassword,
        bool $active,
        string $avatar
 */
