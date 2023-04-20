<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use function Sodium\add;

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
    public function addTodo(Request $request, $name, $content): RedirectResponse{
        $session = $request->getSession();
        if($session->has('tabToDo')){
            $tabToDo = $session->get('tabToDo');
            if(isset($tabToDo[$name])){
                $this->addFlash('error', "La clé $name existe déjà.");
            }
            else{
                $tabToDo[$name] = $content;
                $session->set('tabToDo', $tabToDo);
                $this->addFlash('success', "Le todo $name avec le contenu $content a été ajouté");
            }
        }
        else{
            $this->addFlash('error', 'La liste des todos n\'est pas encore initialisée.');
        }
        return $this->redirectToRoute('todo');
    }

    #[Route('todo/update/{name}/{content}', name: 'todo.update')]
    public function updateTodo(Request $request, $name, $content): RedirectResponse{
        $session = $request->getSession();
        if($session->has('tabToDo')){
            $tabTodo = $session->get('tabToDo');
            if(isset($tabTodo[$name])){
                $tabTodo[$name] = $content;
                $session->set('tabToDo', $tabTodo);
                $this->addFlash('success', "L'élément de clé $name a été mis à jour avec $content.");
            }
            else{
                $this->addFlash('error', "La clé $name n'existe pas.");
            }
        }
        else{
            $this->addFlash('error', 'La liste des todos n\'est pas encore initialisée.');
        }
        return $this->redirectToRoute('todo');
    }

    #[Route('todo/delete/{name}', name: 'todo.delete')]
    public function deleteTodo(Request $request, $name): RedirectResponse{
        $session = $request->getSession();
        if($session->has('tabToDo')){
            $tabTodo = $session->get('tabToDo');
            if(isset($tabTodo[$name])){
                unset($tabTodo[$name]);
                $session->set('tabToDo', $tabTodo);
                $this->addFlash('success', "L'élément de clé $name a bien été supprimé");
            }
            else{
                $this->addFlash('error', "La clé $name n'existe pas.");
            }
        }
        else{
            $this->addFlash('error', 'La liste des todos n\'est pas encore initialisée.');
        }
        return $this->redirectToRoute('todo');
    }

    #[Route('todo/reset', name: 'todo.reset')]
    public function resetTodo(Request $request): RedirectResponse{
        $session = $request->getSession();
        $session->remove('tabToDo');
        return $this->redirectToRoute('todo');
    }
}
