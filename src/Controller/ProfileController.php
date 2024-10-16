<?php

namespace App\Controller;

use App\Entity\LogEntry; // Ensure you have the LogEntry entity imported
use App\Repository\LogRepository; // Import your LogRepository
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class ProfileController extends AbstractController
{
    private $logRepository; // Property for log repository

    public function __construct(LogRepository $logRepository) // Inject LogRepository
    {
        $this->logRepository = $logRepository;
    }

    #[Route("/private-profile", name: 'app_profile')]
    public function show(): Response
    {
        $user = $this->getUser(); // Récupérer l'utilisateur connecté

        return $this->render('profile/profile.html.twig', [
            'user' => $user,
        ]);
    }

    #[Route("/delete-account", name: 'app_delete_account', methods: ['POST'])]
    public function deleteAccount(Request $request, UserRepository $userRepository, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser(); // Récupérer l'utilisateur connecté

        // Vérifiez le CSRF token pour la sécurité
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        // Vérifier le CSRF token
        $csrfToken = $request->request->get('_csrf_token');
        if (!$this->isCsrfTokenValid('delete_account', $csrfToken)) {
            $this->addFlash('error', 'Jeton CSRF invalide.');
            return $this->redirectToRoute('app_profile'); // Redirect back to profile if invalid
        }

        // Supprimer l'utilisateur de la base de données
        if ($user) {
            // Log the deletion event
            $logEntry = new LogEntry();
            $logEntry->setAction('suppression de compte');
            $logEntry->setUser($user); // Assuming your LogEntry has a relation with User
            $logEntry->setTimestamp(new \DateTime());
            $this->logRepository->add($logEntry);

            // Remove the user
            $userRepository->remove($user);
            $this->addFlash('success', 'Votre compte a été supprimé avec succès.');

            // Déconnecter l'utilisateur
            $this->get('security.token_storage')->setToken(null);
            $request->getSession()->invalidate();
        } else {
            $this->addFlash('error', 'Erreur lors de la suppression de votre compte.');
        }

        return $this->redirectToRoute('app_home'); // Rediriger vers la page d'accueil
    }
}
