<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ProviderRepository;

class AdminController extends AbstractController
{
    /**
     * @Route("/", name="admin")
     */
    public function index(ProviderRepository $providerRepository): Response
    {
         

        //return new Response($nbreProducts);
        return $this->render('admin/index.html.twig', [
             'total'=>$providerRepository->totalProviders()
        ]);
    }
}
