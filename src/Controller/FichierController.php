<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Form\FichierType;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Fichier;
use App\Repository\FichierRepository;
use Doctrine\ORM\EntityManagerInterface;

class FichierController extends AbstractController
{
    #[Route('/ajout-fichier', name: 'app_ajout_fichier')]
    public function index(Request $request, EntityManagerInterface $em): Response
    {
        $fichier = new Fichier();
        $form = $this->createForm(FichierType::class,$fichier);
        if($request->isMethod('POST')){
            $form->handleRequest($request);
            if ($form->isSubmitted()&&$form->isValid()){
            $fichier->setDateEnvoi(new \Datetime());
            $em->persist($fichier);
            $em->flush();
            $this->addFlash('notice','Message envoyé');
            return $this->redirectToRoute('app_ajout_fichier');
        }
    }
        return $this->render('fichier/index.html.twig', [
            'form' => $form->createView()
        ]);
    }
    #[Route('/mod-liste-fichiers', name: 'app_liste_fichiers')]
    public function listeContacts(FichierRepository $fichierRepository): Response
    {
    $fichier = $fichierRepository->findAll();
    return $this->render('fichier/liste-fichier.html.twig', [
    'fichier' => $fichier
    ]);
    }

    #[Route('/mod-liste-fichiers/{id}', name: 'app_nombre_fichier')]
 public function supprimerCategorie(FichierRepository $fichierRepository): Response
 {
    $fichier = $fichierRepository->findAll();
 return $this->render('fichier/nombre.html.twig', [
    'fichier' => $fichier
    ]);
 }
}
