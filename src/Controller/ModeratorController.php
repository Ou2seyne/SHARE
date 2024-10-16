<?php

namespace App\Controller;

use App\Entity\LoginLog; // Add this line
use App\Repository\LoginLogRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class ModeratorController extends AbstractController
{
    private LoginLogRepository $loginLogRepository;

    public function __construct(LoginLogRepository $loginLogRepository)
    {
        $this->loginLogRepository = $loginLogRepository;
    }

    #[Route('/mod', name: 'moderator_page')]
    #[IsGranted('ROLE_MOD')]
    public function index(): Response
    {
        // Retrieve all login logs from the database
        $logs = $this->loginLogRepository->findAll();

        return $this->render('moderator/index.html.twig', [
            'logs' => $logs,
        ]);
    }

    #[Route(path: '/post_login', name: 'app_post_login')] // New route for post-login
public function postLogin(): Response
{
    $user = $this->security->getUser(); // Get the authenticated user

    if ($user) {
        // Create a new login log entry
        $loginLog = new LoginLog();
        $loginLog->setUser($user); // Set the authenticated user
        $loginLog->setEmail($user->getEmail()); // Set the user's email
        $loginLog->setLoggedAt(new \DateTime()); // Set the current timestamp

        // Persist the login log entry
        $this->entityManager->persist($loginLog);
        $this->entityManager->flush();
    } else {
        // Handle the case where the user is not authenticated
        // This could happen if the method is called directly without login
        throw new \LogicException('User is not authenticated.');
    }

    return $this->redirectToRoute('homepage'); // Redirect to the homepage or any other route
}
}
