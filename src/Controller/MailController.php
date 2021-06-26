<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MailController extends AbstractController
{
    /**
     * @Route("/mail", name="mail")
     */
    public function index(): Response
    {
        return $this->render('mail/index.html.twig', [
            'controller_name' => 'MailController',
        ]);
    }

/**
* @Route("/sendmail", name="sendmail")
*/
public function testMail(\Swift_Mailer $mailer)
{
$name = "Sesame";
$message = (new \Swift_Message('Hello Email'))
->setFrom('amine.mezghich@ensi-uma.tn')
->setTo('amine.mezghich@gmail.com')
->setBody($this->renderView(
// templates/emails/registration.html.twig
'mail/registration.html.twig', ['name' => $name]
),
'text/html'
);
// you can remove the following code if you don't define a text version for your emails
/*->addPart(
    $this->renderView(
// templates/emails/registration.txt.twig
'emails/registration.txt.twig',
['name' => $name]
),
'text/plain'
)*/
$mailer->send($message);
return new Response("Bravo! mail sent");
}
}
