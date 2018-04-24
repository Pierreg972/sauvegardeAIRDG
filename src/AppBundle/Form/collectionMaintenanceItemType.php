<?php

namespace AppBundle\Form;

use Symfony\Component\Form\Extension\Core\Type\TextType;

class collectionMaintenanceItemType extends \Symfony\Component\Form\AbstractType
{
    public function buildForm(\Symfony\Component\Form\FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('engineName',TextType::class, array('label'=>'Nom de la machine'))
            ->add('maintenanceItems', \Symfony\Component\Form\Extension\Core\Type\CollectionType::class, array(
                'entry_type'   => maintenanceItemType::class,
                'allow_add'    => true,
                'allow_delete' => true,
                'label'        => 'Ajouter des catégories de maintenance',
                'by_reference' => false,
                'entry_options'=> ['label'=>false],
            ))
            ->add('sauvegarder_les_modifications',      \Symfony\Component\Form\Extension\Core\Type\SubmitType::class, ['attr' => ['class' => 'btn btn-primary action-save']]);

    }
}