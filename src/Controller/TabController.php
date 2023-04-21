<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TabController extends AbstractController
{
    #[Route('/tab/{nb<\d+>?5}', name: 'tab')]
    public function index($nb): Response
    {
        $notes = [];
        for ($i = 0; $i < $nb; $i++){
            $notes[$i] = rand(0, 20);
        }
        return $this->render('tab/index.html.twig', [
            'notes' => $notes,
        ]);
    }

    /**
     * @Route("/tab/user", name="tab.user")
     */
    public function users(): Response{
        $users = [
            ['firstname' => 'blbl', 'name' => 'blbl', 'age' => 0],
            ['firstname' => 'prenom', 'name' => 'nom', 'age' => 20],
            ['firstname' => 'test', 'name' => 'test', 'age' => 10],
        ];

        return $this->render('tab/users.html.twig',[
            'users' => $users,
        ]);
    }
}
