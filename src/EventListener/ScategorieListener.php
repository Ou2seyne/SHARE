<?php

namespace App\EventListener;

use Doctrine\ORM\Event\LifecycleEventArgs; // Utiliser LifecycleEventArgs
use App\Entity\Scategorie;

class ScategorieListener
{
    public function prePersist(Scategorie $scategorie, LifecycleEventArgs $event): void
    {
        // Obtenir l'EntityManager depuis LifecycleEventArgs
        $entityManager = $event->getEntityManager();
        
        // Récupérer le repository
        $repository = $entityManager->getRepository(Scategorie::class);
        
        // Vérifier les doublons
        $count = $repository->trouverDoublon($scategorie->getNumero(), $scategorie->getCategorie());
        if ($count > 0) {
            throw new \RuntimeException('Un doublon a été trouvé pour cette sous-catégorie.');
        }
    }
}
