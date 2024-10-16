<?php

namespace App\Form;

use App\Entity\Hostel;
use App\Entity\Manager;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class HostelType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('location')
            ->add('city')
            ->add('country')
            ->add('numberOfRooms')
            ->add('slug')
            ->add('description')
            ->add('image')
            ->add('manager', EntityType::class, [
                'class' => Manager::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Hostel::class,
        ]);
    }
}
