<?php


namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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
}
