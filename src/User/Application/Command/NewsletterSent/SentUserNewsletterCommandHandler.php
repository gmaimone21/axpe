<?php

namespace App\User\Application\Command\NewsletterSent;

use App\Shared\Domain\Bus\HandlerInterface;
use App\User\Domain\Contracts\UserRepositoryInterface;
use App\User\Domain\Model\User;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

#[AsMessageHandler]
class SentUserNewsletterCommandHandler implements HandlerInterface
{
    public function __construct(
        private UserRepositoryInterface $userRepository,
        private MailerInterface $mailer
    )
    {
    }

    public function __invoke(SentUserNewsletterCommand $command)
    {
        try {
            $usersToSent = $this->userRepository->findActiveUsersForNewsletter();
            $this->outputWriteln('Successful get all active users', $command);

            foreach ($usersToSent as $user) {
                $to = $user->getEmail();

                $this->outputWriteln(sprintf('User email: %s', $to), $command);
                $email = (new Email())
                    ->from('domain@example.com')
                    ->to($to)
                    ->subject('hola mundo')
                    ->text('body text')
                ;
                $this->mailer->send($email);
                $this->userSent($user);

            }
        } catch (TransportExceptionInterface $e) {
            $this->outputWriteln(sprintf('Error to sent newsletter:', $e->getMessage()), $command);
        }
    }

    protected function outputWriteln(string $writeln, SentUserNewsletterCommand $command): void
    {
        $command->output->writeln($writeln);
    }

    protected function userSent(User $user): bool
    {
        $date = new \DateTimeImmutable();
        $user->setLastNewsletterSent($date);
        $this->userRepository->save($user);

        return true;
    }
}