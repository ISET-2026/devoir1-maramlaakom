<?php

namespace App\Controller;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Etudiant;
use App\Form\EtudiantType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\EtudiantRepository;
final class EtudiantController extends AbstractController
{
    #[Route('/etudiant', name: 'app_etudiant_new')]
   public function nouveau(Request $request, EntityManagerInterface $em): Response
    {
        $etudiant = new Etudiant();
        
        $form = $this->createForm(EtudiantType::class, $etudiant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($etudiant);
            $em->flush();

            $this->addFlash('success', 'Étudiant ajouté avec succès !');

            return $this->redirectToRoute('app_etudiant_index');
        }

        return $this->render('etudiant/etudiant.html.twig', [
            'formulaire' => $form->createView(), 
        ]);
    }
    #[Route('/etudiant', name: 'app_etudiant_index')] 
public function index(EtudiantRepository $repo): Response 
{
    return $this->render('etudiant/index.html.twig', [
        'etudiants' => $repo->findAll()
    ]);
}
    
}


