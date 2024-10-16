<?php

namespace App\EventListener;

use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use Symfony\Component\Security\Http\Event\LogoutEvent;
use Symfony\Component\Security\Core\Security;
use Psr\Log\LoggerInterface;

class LoginListener
{
    private LoggerInterface $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function onSecurityInteractiveLogin(InteractiveLoginEvent $event): void
    {
        $user = $event->getAuthenticationToken()->getUser();
        // Ajoute une logique pour gérer la connexion, par exemple, loguer l'événement
        $this->logger->info(sprintf('L’utilisateur %s a connecté.', $user->getEmail()));
    }

    public function onLogout(LogoutEvent $event): void
    {
        $user = $event->getToken()->getUser();
        // Ajoute une logique pour gérer la déconnexion
        $this->logger->info(sprintf('L’utilisateur %s a déconnecté.', $user->getEmail()));
    }
}
