<?php

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

use App\Entity\Serie;

class SerieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('title', TextType::class, array(
            'attr' => array('class' => 'form-control')
            ));

        $builder->add('genres', TextType::class, array(
            'attr' => array('class' => 'form-control')
        ));

        $builder->add('description', TextareaType::class, array(
            'required' => false,
            'attr' => array('class' => 'form-control')
        ));

        $builder->add('save', SubmitType::class, array(
            'label' => 'Utwórz',
            'attr' => array('class' => 'btn btn-primary mt-3')
        ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Serie::class,
        ));
    }
}