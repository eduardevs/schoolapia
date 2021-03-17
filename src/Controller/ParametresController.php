<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserParamType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class ParametresController extends AbstractController
{
    /**
     * @Route("/parametres", name="parametres")
     */
    public function index(Security $security, Request $request,  UserPasswordEncoderInterface $encoder): Response
    {
        //Avec le service Security on récupére le user connecté
        $id = $security->getUser()->getId();
        // On récupère la repository des User et on va chercher l'utilisateur par son id
        $repository = $this->getDoctrine()->getRepository(User::class);
        $user = $repository->find($id);
        // Mise en place du formulaire
        $form = $this->createForm(UserParamType::class, $user);
        // On vérifie si on a des données postées dans la requête ce qui signifait que l'on est en mode validation de formulaire et pas affichage simple
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager = $this->getDoctrine()->getManager();
            // Prise en charge d'un changement du password potentiel
            //    On récupere dans la requête la donnée contenue dans le champ non pris en charge par le FormType de Symfony dans la prorpieté request de $request, cette propriété contient lees valeurs POST
            $newPassword = $request->request->get('newPassword');
            // On vérifie si la donnée n'est pas vide
            if (!empty($newPassword)) {
                // ATTENTION : On n'encode pas le nouveau mot de passe parce qu'il est déjà pris en charge dans l'entité User
                // Sinon on aurait utilisé : 
                // $password = $encoder->encodePassword($user, $newPassword);
                $password =  $newPassword;
                // On met à jour la propriété du user
                $user->setPassword($password);
            }
            // On mémorise le contact pour une mise en base de données future
            $entityManager->persist($user);
            // On envoie en bdd
            $entityManager->flush();
            $this->addFlash('success', 'Vos modifications on bien été enregistrées.');
        }
        // Rendu
        return $this->render('parametres/index.html.twig', [
            'form' => $form->createView(),
            'user' => $user
        ]);
    }
}