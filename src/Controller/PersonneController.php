<?php

namespace App\Controller;

use App\Entity\Personne;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/personne')]

class PersonneController extends AbstractController
{

    #[Route('/', name: 'personne.list')]
    public function index(ManagerRegistry $doctrine): Response{
        $repository = $doctrine->getRepository(Personne::class);
        $personnes = $repository->findAll();
        return $this->render('personne/index.html.twig', [
            'personnes' => $personnes,
        ]);
    }

    #[Route('/{id<\d+>}', name: 'personne.detail')]
    public function detail(ManagerRegistry $doctrine, Personne $personne = null): Response{
        if($personne){
            return $this->render('personne/detail.html.twig', [
                'personne' => $personne,
            ]);
        }
        else{
            $this->addFlash('error', "La personne n'existe pas.");
            return $this->redirectToRoute('personne.list');
        }
    }

    #[Route('/add', name: 'personne.add')]
    public function addPersonne(ManagerRegistry $doctrine): Response
    {
        //$this->getDoctrine();
        $entityManager = $doctrine->getManager();
        $personne = new Personne();
        $personne->setFirstname("Perso1");
        $personne->setName("Number1");
        $personne->setAge(1);
        $entityManager->persist($personne);

        //$personne2 = new Personne();
        //$personne2->setFirstname("Perso2");
        //$personne2->setName("Number2");
        //$personne2->setAge(2);
        //$entityManager->persist($personne2);

        $entityManager->flush();
        return $this->render('personne/detail.html.twig', [
            'personne' => $personne,
        ]);
    }
}
