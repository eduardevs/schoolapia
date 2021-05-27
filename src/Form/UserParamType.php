<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserParamType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->remove('username')
            ->remove('roles')
            ->remove('password')
            ->remove('prenom')
            ->remove('nom')
            ->add('dateNaissance', BirthdayType::class)
            ->add('email', EmailType::class) //EmailType::class
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
