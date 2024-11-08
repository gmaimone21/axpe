<?php

namespace App\User\Application\Command\NewsletterSent;

use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SentUserNewsletterCommand
{
    public function __construct(
        public OutputInterface $output
    ) {
    }
}