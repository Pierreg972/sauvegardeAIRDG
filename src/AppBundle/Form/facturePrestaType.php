<?php

namespace AppBundle\Form;

class facturePrestaType extends \Symfony\Component\Form\AbstractType
{
    public function buildForm(\Symfony\Component\Form\FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('prestas', \Symfony\Component\Form\Extension\Core\Type\CollectionType::class, array(
                'entry_type'   => \AppBundle\Form\ContentPrestationType::class,
                'allow_add'    => true,
                'allow_delete' => true,
                'by_reference' => false
            ))
            ->add('save',      \Symfony\Component\Form\Extension\Core\Type\SubmitType::class);

    }
}