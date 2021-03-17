<?php

namespace App\Controller;

use App\Entity\Note;
use App\Entity\Evaluation;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ScolariteController extends AbstractController
{
    /**
     * @Route("/scolarite", name="scolarite")
     * @Route("/scolarite/note", name="note")
     */
    public function index(Security $security): Response
    {
        $user = $security->getUser();
        $repository = $this->getDoctrine()->getRepository(Note::class);
        $notes = $repository->findBy(array("utilisateurs"=>$user));

        return $this->render('scolarite/index.html.twig', [
            'notes' => $notes
        ]);
    }

    /**
     * @Route("/scolarite/evaluation", name="evaluation")
     */
    public function evaluation(): Response
    {
        // 
        $repository = $this->getDoctrine()->getRepository(Evaluation::class);
        $evaluations = $repository->findAll();

        return $this->render('scolarite/evaluation.html.twig', [
            'evaluations' => $evaluations,
        ]);
    }
}
