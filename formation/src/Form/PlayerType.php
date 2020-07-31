<?php

namespace App\Form;

use App\Entity\Player;
use App\Entity\Team;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PlayerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname', null, [
                'attr' => ['class' => 'form-control'],
                'row_attr' => ['class' => 'form-group']
            ])
            ->add('lastname', null, [
                'attr' => ['class' => 'form-control'],
                'row_attr' => ['class' => 'form-group']
            ])
            ->add('birthdate', null, [
                'attr' => ['class' => 'form-control'],
                'row_attr' => ['class' => 'form-group']
            ])
            ->add('number', null, [
                'attr' => ['class' => 'form-control'],
                'row_attr' => ['class' => 'form-group']
            ])
            ->add('position', null, [
                'attr' => ['class' => 'form-control'],
                'row_attr' => ['class' => 'form-group']
            ])
            ->add('team', EntityType::class, [
                'class' => Team::class,
                'choice_label' => 'name',
                'attr' => ['class' => 'form-control'],
                'row_attr' => ['class' => 'form-group']
            ])
            ->add('save', SubmitType::class, ['label' => 'Créer',
                'attr' => ['class' => 'btn btn-primary btn-lg btn-block']
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Player::class,
        ]);
    }
}
