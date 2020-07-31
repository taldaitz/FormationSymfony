<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', null, ['disabled' => true,
                'attr' => ['class' => 'form-control'],
                'row_attr' => ['class' => 'form-group']
            ])
            ->add('rolesString', null, ['disabled' => true,
                'attr' => ['class' => 'form-control'],
                'row_attr' => ['class' => 'form-group']
            ])
            ->add('lastname', null, [
                'attr' => ['class' => 'form-control'],
                'row_attr' => ['class' => 'form-group']
            ])
            ->add('firstname', null, [
                'attr' => ['class' => 'form-control'],
                'row_attr' => ['class' => 'form-group']
            ])

            ->add('clearPassword', PasswordType::class, [
                'mapped' => false,
                'label' => "Mot de passe",
                'attr' => ['class' => 'form-control'],
                'row_attr' => ['class' => 'form-group']
            ])

            ->add('modifier', SubmitType::class, [
                'label' => 'Mettre à jour',
                'attr' => ['class' => 'btn btn-primary btn-lg btn-block']
            ])
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
