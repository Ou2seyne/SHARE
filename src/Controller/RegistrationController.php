<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Security\AppCustomAuthenticator;
use Doctrine\ORM\EntityManagerInterface;
use Defuse\Crypto\Crypto;
use Defuse\Crypto\Key;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

class RegistrationController extends AbstractController
{
    #[Route('/register', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, Security $security, EntityManagerInterface $entityManager): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Encode le mot de passe
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            // Définir la date d'envoi
            $user->setDateEnvoi(new \DateTime()); // Définit la date d'envoi à l'heure actuelle
            
            // Chiffrement de données sensibles (exemple: numéro de téléphone, adresse, etc.)
            // Supposons que vous ayez un champ `sensitiveData` dans l'entité User
            $sensitiveData = $form->get('sensitiveData')->getData(); // Remplacez par le champ approprié
            $key = Key::createNewRandomKey(); // Ou récupérez une clé sécurisée stockée
            $ciphertext = Crypto::encrypt($sensitiveData, $key);
            $user->setSensitiveData($ciphertext); // Mettez à jour le champ sensible dans l'entité

            // Persister l'utilisateur
            $entityManager->persist($user);
            $entityManager->flush();
        
            // Faites tout autre traitement nécessaire ici, comme envoyer un e-mail
        
            return $security->login($user, AppCustomAuthenticator::class, 'main');
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form,
        ]);
    }
}
