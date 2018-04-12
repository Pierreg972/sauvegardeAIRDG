<?php

namespace AppBundle\Form;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class maintenanceItemType extends \Symfony\Component\Form\AbstractType
{
    public function buildForm(\Symfony\Component\Form\FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name',TextType::class, array('label'=>'Nom de catégorie'))
            ->add('items', \Symfony\Component\Form\Extension\Core\Type\CollectionType::class, array(
                'entry_type'   => itemType::class,
                'allow_add'    => true,
                'allow_delete' => true,
                'by_reference' => false,
                'entry_options'=> ['label'=>false],
            ));

    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\maintenanceItem'
        ));
    }
}