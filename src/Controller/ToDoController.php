<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ToDoController extends AbstractController
{
    #[Route('/todo', name: 'todo')]
    public function index(Request $request): Response
    {
        $session = $request->getSession();
        if(!$session->has('tabToDo')){
            $tabToDo = [
                'achat' => 'acheter clé usb',
                'cours' => 'finaliser le cours',
                'correction' => 'corriger les examens'
            ];
            $session->set('tabToDo', $tabToDo);
            $this->addFlash('info', 'La liste des todos viens d\'être initialisée.');
        }

        return $this->render('to_do/index.html.twig');
    }

    #[Route('/todo/add/{name}/{content}', name: 'todo.add')]
    public function addTodo(Request $request, $name, $content){
        $session = $request->getSession();
        if($session->has('tabToDo')){
            $tabToDo = $session->get('tabToDo');
            if(isset($tabToDo[$name])){
                $this->addFlash('error', "La clé $name existe déjà.");
            }
            else{
                $tabToDo[$name] = $content;
                $this->addFlash('success', "Le todo $name avec le contenu $content a été ajouté");
                $session->set('tabToDo', $tabToDo);
            }
        }
        else{
            $this->addFlash('error', 'La liste des todos n\'est pas encore initialisée.');
        }
        return $this->redirectToRoute('todo');
    }
}
