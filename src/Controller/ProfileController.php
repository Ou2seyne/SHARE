<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class ProfileController extends AbstractController
{
    #[Route("/private-profile", name: 'app_profile')]
    public function show(): Response
    {
        $user = $this->getUser(); // Récupérer l'utilisateur connecté

        return $this->render('profile/profile.html.twig', [
            'user' => $user,
        ]);
    }

    #[Route("/delete-account", name: 'app_delete_account', methods: ['POST'])]
    public function deleteAccount(Request $request, UserRepository $userRepository): Response
    {
        $user = $this->getUser(); // Récupérer l'utilisateur connecté

        // Vérifiez le CSRF token pour la sécurité
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        // Supprimer l'utilisateur de la base de données
        if ($user) {
            $userRepository->remove($user);
            $this->addFlash('success', 'Votre compte a été supprimé avec succès.');
        } else {
            $this->addFlash('error', 'Erreur lors de la suppression de votre compte.');
        }

        // Déconnecter l'utilisateur
        $this->get('security.token_storage')->setToken(null);
        $request->getSession()->invalidate();

        return $this->redirectToRoute('app_home'); // Rediriger vers la page d'accueil
    }
}
