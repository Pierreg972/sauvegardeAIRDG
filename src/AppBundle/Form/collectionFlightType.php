<?php

namespace AppBundle\Form;

class collectionFlightType extends \Symfony\Component\Form\AbstractType
{
    public function buildForm(\Symfony\Component\Form\FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('flights', \Symfony\Component\Form\Extension\Core\Type\CollectionType::class, array(
                'entry_type'   => \AppBundle\Form\flightType::class,
                'allow_add'    => true,
                'allow_delete' => true
            ));
    }
}