<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\Currency;
  
class DeviseController extends AbstractController
{
    /**
     * @Route("/devise", name="devise")
     */
    public function index(): Response
    {
        return $this->render('devise/index.html.twig', [
            'controller_name' => 'DeviseController',
        ]);
    }

/**
* @Route("/cours", name="cours")
*/

// injection de dépendences  de l'objet de type Currency
    public function cours(Currency $my_service, Request $request)
        {
            // On récupère le service et on spécifie les paramètres
            $from = "USD";

            $resultat = 0;

        if($request->getMethod()=="POST")
        {
                $devisecible = $request->get('devisecible');
                $montant = $request->get('montant');
                $resultat = $my_service->conversion($from,$devisecible,$montant);
                $resultat = number_format($resultat, 2);
                $response = new Response(json_encode(array('resultat' => $resultat)));
                $response->headers->set('Content-Type', 'application/json');
                return $response;
        }

        return $this->render('devise/index.html.twig', ['resultat' =>  $resultat]);
    }
}
