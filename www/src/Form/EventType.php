<?php

namespace App\Form;

use App\Entity\Event;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EventType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('label', TextType::class, [
                'label' => 'Label',
            ])
            ->add('dateStart', DateTimeType::class, [
                'label' => 'Start Date',
                'widget' => 'single_text',
            ])
            ->add('dateEnd', DateTimeType::class, [
                'label' => 'End Date',
                'widget' => 'single_text',
            ])
            ->add('recurrence', TextType::class, [
                'label' => 'Recurrence',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Event::class,
        ]);
    }
}
