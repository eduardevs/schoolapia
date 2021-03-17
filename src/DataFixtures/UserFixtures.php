<?php

namespace App\DataFixtures;

use App\Entity\User;

use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    // Propriétés

    private $encoder;
    // Conctructeur

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }
    // Méthodes
    public function load(ObjectManager $manager)
    {

        $user = new User();
        $user->setEmail('eleve@test.com');

        $passwordOrigine = "password";
        // Avant de mettre en place le encode dans l'entite User
        // $passwordEncode = $this->encoder->encodePassword($user, $passwordOrigine);
        // $user->setPassword($passwordEncode);

        $user->setPassword($passwordOrigine);

        $user->setRoles(['ROLE_USER']);

        $user->setNom("Test");
        $user->setPrenom("Eleve");
        $user->setUsername("eleve-test");

        $manager->persist($user);

        $user = new User();
        $user->setEmail('prof@test.com');

        $passwordOrigine = "password";
     
        $user->setPassword($passwordOrigine);

        $user->setRoles(['ROLE_ADMIN']);

        $user->setNom("Test");
        $user->setPrenom("Prof");
        $user->setUsername("prof-test");

        $manager->persist($user);
        $user = new User();
        $user->setEmail('super@test.com');

       $passwordOrigine = "password";
        // $passwordEncode = $this->encoder->encodePassword($user, $passwordOrigine);
        
        $user->setPassword($passwordOrigine);

        $user->setRoles(['ROLE_SUPER_ADMIN']);

        $user->setNom("Test");
        $user->setPrenom("Super");
        $user->setUsername("super-test");

        $manager->persist($user);

        $manager->flush();
        

    }
    //Getters/Setters
}
