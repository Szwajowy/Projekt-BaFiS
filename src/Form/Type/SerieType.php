<?php

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

use App\Entity\Production;

use App\Form\Type\GenreType;

class SerieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('title', TextType::class, array());

        $builder->add('idgenre', CollectionType::class, array(
            'entry_type' => GenreType::class,
            'label' => "Genre",
            'by_reference' => false,
            'allow_add' => true,
            'allow_delete' => true,
        ));

        $builder->add('description', TextareaType::class, array(
            'required' => false,
        ));

        $builder->add('save', SubmitType::class, array(
            'label' => 'Utwórz',
        ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Production::class,
        ));
    }
}