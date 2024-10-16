<?php
namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\ContactType;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Contact;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\CategorieType;
use App\Entity\Categorie;

class BaseController extends AbstractController


{
#[Route('/', name: 'app_accueil')]
public function index(): Response
{
return $this->render('base/index.html.twig', [
]);
}


#[Route('/mention', name: 'app_mention')]
public function mention(): Response
    {
return $this->render('base/mention.html.twig', [
]);
}

#[Route('/propos', name: 'app_propos')]
public function propos(): Response
    {
return $this->render('base/propos.html.twig', [
]);
}

#[Route('/private-contact', name: 'app_contact')]
 public function contact(Request $request, EntityManagerInterface $em): Response
 {
 $contact = new Contact();
 $form = $this->createForm(ContactType::class,$contact);
 if($request->isMethod('POST')){
 $form->handleRequest($request);
 if ($form->isSubmitted()&&$form->isValid()){
 $contact->setDateEnvoi(new \Datetime());
 $em->persist($contact);
 $em->flush();
 $this->addFlash('notice','Message envoyé');
 return $this->redirectToRoute('app_contact');
 }
 }
 return $this->render('base/contact.html.twig', [
 'form' => $form->createView()
 ]);
 }




    #[Route('/private-categorie', name: 'app_categorie')]
    public function categorie(Request $requestt,EntityManagerInterface $ems): Response
    {
    $categorie = new Categorie();
    $form = $this->createForm(CategorieType::class,$categorie);
    if($requestt->isMethod('POST')){
        $form->handleRequest($requestt);
        if ($form->isSubmitted()&&$form->isValid()){
            $ems->persist($categorie);
            $ems->flush();
            $this->addFlash('notice','Message envoyé');
            return $this->redirectToRoute('app_categorie');
    }
    }
    return $this->render('base/categorie.html.twig', [
    'form' => $form->createView()
    ]);
    }
}