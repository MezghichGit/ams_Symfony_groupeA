<?php

namespace App\Controller;

use App\Entity\Provider;
use App\Form\ProviderType;
use App\Repository\ProviderRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/provider")
 */
class ProviderController extends AbstractController
{
    /**
     * @Route("/list", name="provider_index", methods={"GET"})
     */
    public function index(ProviderRepository $providerRepository): Response
    {
        

        return $this->render('provider/index.html.twig', [
            'providers' => $providerRepository->findAll(),
          
           
        ]);


        /*
        return $this->render('provider/list.html.twig', [
            'providers' => $providerRepository->findAll(),
        ]);*/
    }

    /**
     * @Route("/new", name="provider_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
      
        $provider = new Provider();

        //$provider->setName("HP");
        //$provider->setAdress("Toto");
        //$provider->setEmail("CC");

        $form = $this->createForm(ProviderType::class, $provider);

        $form->handleRequest($request);
       
        if ($form->isSubmitted() && $form->isValid()) {

            $photoFile = $form->get('photo')->getData();

            if ($photoFile) {
                $originalphotoFilename = pathinfo($photoFile->getClientOriginalName(), PATHINFO_FILENAME);
                
                // $safePhotoFilename = transliterator_transliterate('AnyLatin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()', $originalphotoFilename);
                 $newPhotoFilename = $originalphotoFilename.'-'.uniqid().'.'.$photoFile->guessExtension();

                 // Move the file to the directory where brochures are stored
            try {
                $photoFile->move($this->getParameter('providers_directory'), $newPhotoFilename
                );
            
                } catch (FileException $e) {
                
                }
            $provider->setPhoto($newPhotoFilename);
            }
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($provider);
            $entityManager->flush();

            return $this->redirectToRoute('provider_index');
        }

        return $this->render('provider/new.html.twig', [
            'provider' => $provider,
            'form' => $form->createView(),
            
        ]);
    }

    /**
     * @Route("/{id}", name="provider_show", methods={"GET"})
     */
    public function show(Provider $provider): Response
    {
        return $this->render('provider/show.html.twig', [
            'provider' => $provider,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="provider_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Provider $provider): Response
    {
        $form = $this->createForm(ProviderType::class, $provider);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('provider_index');
        }

        return $this->render('provider/edit.html.twig', [
            'provider' => $provider,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="provider_delete", methods={"POST"})
     */
    public function delete(Request $request, Provider $provider): Response
    {
        if ($this->isCsrfTokenValid('delete'.$provider->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($provider);
            $entityManager->flush();
        }

        return $this->redirectToRoute('provider_index');
    }
}
