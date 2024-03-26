<?php
namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ContactRepository;
use App\Form\ModifierCategorieType;
class ContactController extends AbstractController
{
    #[Route('/mod-liste-contacts', name: 'app_liste_contacts')]
    public function listeContacts(ContactRepository $contactRepository): Response
    {
    $contacts = $contactRepository->findAll();
    return $this->render('contact/liste-contacts.html.twig', [
    'contacts' => $contacts
    ]);
    }
}
