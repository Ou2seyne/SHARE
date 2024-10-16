<?php

namespace App\EventListener;

use App\Entity\LogEntry; // Assurez-vous que vous avez importé votre classe LogEntry
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use Symfony\Component\Security\Http\Event\LogoutEvent;

class LoginListener
{
    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    public function onSecurityInteractiveLogin(InteractiveLoginEvent $event): void
    {
        $user = $event->getAuthenticationToken()->getUser();

        $logEntry = new LogEntry();
        $logEntry->setAction('connexion')
            ->setUsername($user->getEmail()) // Assurez-vous d'avoir cette méthode
            ->setTimestamp(new \DateTime());

        $this->entityManager->persist($logEntry);
        $this->entityManager->flush();
    }

    public function onSecurityLogout(LogoutEvent $event): void
    {
        $user = $event->getToken()->getUser();

        $logEntry = new LogEntry();
        $logEntry->setAction('deconnexion')
            ->setUsername($user->getEmail()) // Assurez-vous d'avoir cette méthode
            ->setTimestamp(new \DateTime());

        $this->entityManager->persist($logEntry);
        $this->entityManager->flush();
    }
}
