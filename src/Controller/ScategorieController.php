<?php

namespace App\Controller;

use App\Entity\Scategorie;
use App\Repository\ScategorieRepository;
use App\Form\AjoutScategorieType;
use App\Form\ModifierSousCategorieType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ScategorieController extends AbstractController
{
    #[Route('/private-ajout-scategorie', name: 'app_ajout_scategorie')]
    public function ajouterScategorie(Request $request, EntityManagerInterface $entityManager): Response
    {
        $scategorie = new Scategorie();
        $form = $this->createForm(AjoutScategorieType::class, $scategorie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $entityManager->persist($scategorie);
                $entityManager->flush();
                $this->addFlash('success', 'Sous-catégorie ajoutée avec succès');
                return $this->redirectToRoute('app_ajout_scategorie');
            } catch (\RuntimeException $e) {
                $this->addFlash('error', $e->getMessage());
            }
        }

        return $this->render('scategorie/ajout-scategorie.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/private-modifier-sous_categorie/{id}', name: 'app_modifier_sous_categorie')]
    public function modifierCategorie(Request $request, Scategorie $scategorie, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ModifierSousCategorieType::class, $scategorie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            $this->addFlash('success', 'Sous-catégorie modifiée avec succès');
            return $this->redirectToRoute('app_liste_categories');
        }

        return $this->render('scategorie/modifier-scategorie.html.twig', [
            'form' => $form->createView(),
            'scategorie' => $scategorie,
        ]);
    }

    #[Route('/sous-categories', name: 'scategorie_liste')]
    public function liste(EntityManagerInterface $em): Response
    {
        $scategories = $em->getRepository(Scategorie::class)->findAll();

        return $this->render('scategorie/liste.html.twig', [
            'scategories' => $scategories,
        ]);
    }

    #[Route('/private-supprimer-sous_categorie/{id}', name: 'app_supprimer_sous_categorie')]
public function supprimerCategorie(Request $request, Scategorie $scategorie, EntityManagerInterface $entityManager): Response
{
    // Vérifie le token CSRF pour éviter les attaques CSRF
    if ($this->isCsrfTokenValid('delete' . $scategorie->getId(), $request->request->get('_token'))) {
        try {
            // Supprime la sous-catégorie
            $entityManager->remove($scategorie);
            $entityManager->flush();
            $this->addFlash('success', 'Sous-catégorie supprimée avec succès');
        } catch (\RuntimeException $e) {
            // Gère les exceptions et ajoute un message d'erreur
            $this->addFlash('error', $e->getMessage());
        }
    } else {
        $this->addFlash('error', 'Token CSRF invalide.');
    }

    // Redirige vers la liste des sous-catégories après la suppression
    return $this->redirectToRoute('scategorie_liste');
}
}