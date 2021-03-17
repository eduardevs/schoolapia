<?php

namespace App\Controller;

use App\Entity\Actualite;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ActualiteController extends AbstractController
{
    /**
     * @Route("/actualites", name="actualites")
     */
    public function index(): Response
    {
        $repository = $this->getDoctrine()->getRepository(Actualite::class);
        $actualites = $repository->findBy(array(), array('rank'=>'DESC'));

        return $this->render('actualite/index.html.twig', [
            'actualites' => $actualites,
        ]);
    }

    /**
     * @Route("/actualites/archives", name="actualites-archives")
     */
    public function actualiteArchive(): Response
    {
        $repository = $this->getDoctrine()->getRepository(Actualite::class);
        $actualites = $repository->findBy(array(), array('rank'=>'DESC'));

        return $this->render('actualite/archive.html.twig', [
            'actualites' => $actualites,
        ]);
    }
    /**
     * Méthode qui prend en charge l'affichage du détail d'une collection 
     * @Route("/actualites/{slug}", name="actualite-detail")
     * @return Response
     */
    public function actualiteDetail($slug): Response
    {
        $repository = $this->getDoctrine()->getRepository(Actualite::class);
        $actualite = $repository->find($slug);
        return $this->render('actualite/detail.html.twig', [
            "actualite"=>$actualite
            ]);
    }
}
