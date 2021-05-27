<?php

namespace App\Controller;

use App\Entity\Message;
use App\Form\CommunicationType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class CommunicationController extends AbstractController
{
    /**
     * @Route("/communication", name="communication")
     */
    public function index(): Response
    {
        // On fait une récupération de la repository de l'entité Collections afin de faire une
        // requête pour récupérer toutes les collections classées par rank croissant
        $repository = $this->getDoctrine()->getRepository(Message::class);
        $messages = $repository->findAll();
        // On déclenche le rendu de la vue
        return $this->render('communication/index.html.twig', [
            'messages' => $messages,
        ]);
    }

    /**
     * 
     *@Route("/communication/{slug}", name="communication-detail")
     * @return Response
     */
    public function communicationMessage($slug, Request $request): Response
    {
        // 1) On instancie un objet avec new.
        $communication = new Message();
        // 2)
        $form = $this->createForm(CommunicationType::class, $communication);

        $repository = $this->getDoctrine()->getRepository(Message::class);
        $message = $repository->find($slug);
        // 3)
        $form->handleRequest($request);
        // 4)
        if ($form->isSubmitted() && $form->isValid()) {
            $communication->setSender($this->getUser());
            // Mise en base de données
            $entityManager = $this->getDoctrine()->getManager();
            //On récupère ensuite le manager d'entity qui permet les transacntions avec la BDD
            $entityManager->persist($communication);
            // 
            $entityManager->flush();
            // On rédirige vers la page de confirmation
            return $this->redirectToRoute("communication");
        }
        return $this->render('communication/message.html.twig', [
            'message' => $message,
            'form' => $form->createView(),

        ]);
    }
    /**
     * $Route("/communication/confirmation", name="communication_confirmation")
     */
    public function confirmation()
    {
        return $this->render("communication/confirmation.html.twig");
    }
    // Mise en place du Remove message
      /**
     * $Route("/communication/delete", name="communication-delete")
     */
    public function removeMessage()
    {
        // return $this->render("communication/confirmation.html.twig");
    }

}
