<?php

namespace App\Form;

use App\Entity\Film;
use App\Entity\Role;
use App\Entity\Actor;
use App\Entity\Casting;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class CastingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('actor', EntityType::class,[
                'class'=> Actor::class, 
                'choice_label' => 'surname_actor'
            ])
            ->add('role', EntityType::class,[
                'class'=> Role::class, 
                'choice_label' => 'name_role'
            ])
            ->add('film', EntityType::class,[
                'class'=> Film::class, 
                'choice_label' => 'title_film'
            ])
            ->add('Submit', SubmitType::class)
           
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Casting::class,
        ]);
    }
}
