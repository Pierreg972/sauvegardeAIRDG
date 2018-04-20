<?php

namespace AppBundle\Form;


use Symfony\Component\OptionsResolver\OptionsResolver;

class facturePrestaType extends \Symfony\Component\Form\AbstractType
{
    public function buildForm(\Symfony\Component\Form\FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('prestas', \Symfony\Component\Form\Extension\Core\Type\CollectionType::class, array(
                'entry_type'   => \AppBundle\Form\ContentPrestationType::class,
                'allow_add'    => true,
                'allow_delete' => true,
                'by_reference' => false,
                'label'        => 'Ajouter des prestations',
            ))
            ->add('sauvegarder_les_modifications',      \Symfony\Component\Form\Extension\Core\Type\SubmitType::class, ['attr' => ['class' => 'btn btn-primary action-save col-xs-2']]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'AppBundle\Entity\Facture',
        ]);
    }

    public function getBlockPrefix()
    {
        return 'facturePrestaType';
    }
}