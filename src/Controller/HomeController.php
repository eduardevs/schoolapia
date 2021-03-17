<?php

namespace App\Controller;

use App\Entity\Carousel;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    /**
     * @Route("/accueil", name="accueil")
     */
    public function index(): Response
    {
        $repository = $this->getDoctrine()->getRepository(Carousel::class);
        $carouselActive = $repository->findOneBy(array("active"=> 1));
        
        return $this->render('home/index.html.twig', [
            'carousel' => $carouselActive,
        ]);
    }
}
