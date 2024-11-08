<?php

namespace App\User\Infrastructure\Symfony\Command;

use App\Shared\Domain\Bus\DispatcherInterface;
use App\User\Application\Command\NewsletterSent\SentUserNewsletterCommand;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Psr\Log\LoggerInterface;

#[AsCommand(name: 'app:user:sent_newsletter')]
class SentNewsletterCommand extends Command
{
    public function __construct(
        private DispatcherInterface $dispatcher

    ) {
        parent::__construct(null);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->dispatcher->dispatch(
            new SentUserNewsletterCommand(
                $output
            )
        );
        $output->writeln('Finished successfully');

        return Command::SUCCESS;
    }
}
