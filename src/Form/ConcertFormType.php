<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Concert;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ConcertFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('groupName')
            ->add('date', DateType::class, [ 
                'widget' => 'single_text',
                          'html5' => false,
                          'attr' => ['class' => 'js-datepicker'],
                ])
            ->add('price')
            ->add('link')
            ->add('city')
            ->add('place')
            ->add('description', TextareaType::class, [
                'required'   => false,
                'empty_data' => '',
            ])
            ->add('categories', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'name',
                'multiple' => true,
                'expanded' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Concert::class,
        ]);
    }
}
