<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\UserRepository;

class UserController extends AbstractController
{
    #[Route('/mod-liste-utilisateurs', name: 'app_liste_utilisateurs')]
    public function listeUser(UserRepository $userRepository): Response
    {
    $user = $userRepository->findAll();
    return $this->render('user/liste-user.html.twig', [
    'user' => $user
    ]);
    }
}
