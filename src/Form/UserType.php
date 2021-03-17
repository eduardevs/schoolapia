<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username')
            ->remove('roles')
            ->add('password', PasswordType::class)
            ->add('prenom')
            ->add('nom')
            ->add('dateNaissance')
            ->add('email', EmailType::class)
            ->add('telephone')
            ->add('adresse')
            ->add('codePostal')
            ->add('ville')
            ->remove('discussions')
            ->remove('classes')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
