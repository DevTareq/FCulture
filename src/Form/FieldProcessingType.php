<?php

namespace App\Form;

use App\Entity\Tractor;
use App\Entity\Field;
use App\Entity\Crop;
use App\Entity\FieldProcessing;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class FieldProcessingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            #->add('date')
            ->add('field', EntityType::class, [
                'class'        => Field::class,
                'choice_label' => 'name',
            ])
            ->add('tractor', EntityType::class, [
                'class'        => Tractor::class,
                'choice_label' => 'name',
            ])
            ->add('crop', EntityType::class, [
                'class'        => Crop::class,
                'choice_label' => 'name',
            ])
            ->add('area');;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => FieldProcessing::class,
        ]);
    }
}
