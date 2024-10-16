<?php

namespace App\EventListener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use App\Entity\YourEntity;

class YourEntityListener
{
    public function prePersist(LifecycleEventArgs $args): void
    {
        $entity = $args->getObject();

        // Vérifie si l'entité est celle que tu veux gérer
        if (!$entity instanceof YourEntity) {
            return;
        }

        // Accède à l'EntityManager
        $entityManager = $args->getEntityManager();
        
        // Exemple de logique avant la persistance
        // $entity->setSomeProperty('value'); // Par exemple
    }
}
