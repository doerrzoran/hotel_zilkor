<?php

namespace App\Form;

use App\Entity\Booking;
use App\Entity\Guest;
use App\Entity\Room;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\GreaterThan;

class BookingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('arrivalDate', DateType::class, [
                'widget' => 'single_text',
                'html5' => false,
                'format' => 'yyyy-MM-dd',
                'attr' => ['class' => 'js-datepicker'],
                'constraints' => [
                    new GreaterThan(['value' => 'today', 'message' => 'The arrival date must be in the future.']),
                ],
            ])
            ->add('departureDate', DateType::class, [
                'widget' => 'single_text',
                'html5' => false,
                'format' => 'yyyy-MM-dd',
                'attr' => ['class' => 'js-datepicker'],
                'constraints' => [
                    new GreaterThan([
                        'propertyPath' => 'parent.all[arrivalDate].data',
                        'message' => 'The departure date must be after the arrival date.',
                    ]),
                ],
            ])
            ->add('room', EntityType::class, [
                'class' => Room::class,
                'required' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Booking::class,
            'csrf_protection' => false,
        ]);
    }
}
