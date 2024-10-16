<?php

namespace App\Service;

use Psr\Log\LoggerInterface;

class AuthLogger
{
    private LoggerInterface $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function logLogin(string $username): void
    {
        $this->logger->info(sprintf('User %s has logged in.', $username));
    }

    public function logLogout(string $username): void
    {
        $this->logger->info(sprintf('User %s has logged out.', $username));
    }
}
