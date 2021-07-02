<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AjaxController extends AbstractController
{
    
    /**
    * @Route("/ajax", name="ajax")
    */
    public function ajax(Request $request)
    {
    /* on récupère la valeur envoyée par la vue */
    $personnage = $request->request->get('personnage');
        switch ($personnage) {
            case 'Homer':
                $titre = 'Simpsons';
                $producteur = 'Matt Groening';
            break;
            case 'Cartman':
                $titre = 'South Park';
                $producteur = 'Trey Parker and Matt Stone';
            break;
            case 'Elsa':
                $titre = 'Reine des neiges';
                $producteur = 'Walt Disney Animation Studios';
            break;
                case 'Lord Farquaad':
                $titre = 'Shrek';
                $producteur = 'Dreamworks';
        }
        /* la réponse doit être encodée en JSON ou XML, on choisira le JSON
        * la doc de Symfony est bien faite si vous devez renvoyer un objet
        *
        */
    $response = new Response(json_encode(array('titre' => $titre,'producteur' => $producteur
    )));

    $response->headers->set('Content-Type', 'application/json');
    return $response;
    }
}