<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FirstController extends AbstractController
{

    /**
     * @Route("/template", name="template")
     *
     */
    public function template(){
        return $this->render('template.html.twig');
    }

    /*
    #[Route('{maVar}', name: 'test.order.route')]
    public function testOrderRoute($maVar): Response
    {
        return new Response("<html><body>$maVar</body></html>");
    }*/

    #[Route('/first', name: 'first')]
    public function index(): Response
    {
        return $this->render('first/index.html.twig', [
            'firstname' => "Pika",
            'name' => "UwU",
            'path' => '   ',
        ]);
        //return new Response("<head><title>Première page</title></head><body><p>Bou</p></body>");
    }

    #[Route('/sayHello/{name}/{firstname}', name: 'say.hello')]
    public function sayHello(Request $request, $name, $firstname): Response
    {
        /*
        $rand = rand(0, 10);
        echo $rand;
        if($rand%2 == 0){
            return $this->redirectToRoute('first');
        }
        return $this->forward('App\Controller\FirstController::index');
        */
        //dd($request);
        //die and dumb
        //le get est dans le query
        //le post est dans le request
        return $this->render('first/hello.html.twig', ['name' => $name, 'firstname' => $firstname, 'path' => '    ']);
        //return new Response("<head><title>Première page</title></head><body><p>Bou</p></body>");
    }

    #[Route('multi/{entier1<\d+>}/{entier2}',
        name: 'multiplication',
        //utilise le regex
        requirements: ['entier2' => '\d+']
    )]
    public function multiplication($entier1, $entier2): Response
    {
        $resultat = $entier1 * $entier2;
        return new Response("<h1>$resultat</h1>");
    }


}
