<?php

namespace App\User\Infrastructure\Doctrine\Persistence;

use App\User\Domain\Contracts\UserRepositoryInterface;
use App\User\Domain\Model\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<User>
 */
class DoctrineUserRepository implements UserRepositoryInterface
{
    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    public function save(User $user): void
    {
        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }

    public function findUserByEmail(string $email): ?User
    {
        return $this->entityManager->getRepository(User::class)->findOneBy(['email' => $email]);
    }

    public function find(string $id): ?User
    {
        return $this->entityManager->getRepository(User::class)->find($id);
    }

    public function findActiveUsersForNewsletter(): array
    {
        $previousWeek = new \DateTimeImmutable('-7 days');

        return $this->entityManager->getRepository(User::class)
            ->createQueryBuilder('u')
            ->where('u.active = :active')
            ->andWhere('u.lastNewsletterSent <= :previousWeek')
            ->orWhere('u.lastNewsletterSent is null and u.active = 1')
            ->setParameter('active', true)
            ->setParameter('previousWeek', $previousWeek)
            ->getQuery()
            ->getResult();
    }
}
