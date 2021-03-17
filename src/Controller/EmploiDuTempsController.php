<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EmploiDuTempsController extends AbstractController
{
    /**
     * @Route("/viescolaire", name="viescolaire")
     * @Route("/viescolaire/emploidutemps", name="emploidutemps")
     */
    public function index(): Response
    {
        return $this->render('emploidutemps/index.html.twig', [
            'controller_name' => 'EmploiDuTempsController',
        ]);
    }
}
