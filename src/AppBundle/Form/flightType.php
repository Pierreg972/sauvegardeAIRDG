<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class flightType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('departureDate',   DateType::class, array('label'=>'Date', 'html5' => false, 'widget' => 'single_text', 'attr' => array('class' => 'col-xs-2 js-datepicker')))
            ->add('departure',TextType::class, array('label'=>'Lieu de départ'))
            ->add('arrival',     TextType::class, array('label'=>"Lieu d'arrivée"))
            ->add('taxName',TextType::class, array('label'=>'Taxe et parking', 'required' => false))
            ->add('taxPrice',     NumberType::class, array('label'=>"Prix de la taxe", 'required' => false))
            ->add('piloteName',TextType::class, array('label'=>'Nom du pilote', 'required' => false))
            ->add('piloteFee',     NumberType::class, array('label'=>"Prix du pilote", 'required' => false))
            ->add('flightDuration',TimeType::class, array('label'=>'Durée du vol', 'widget' => 'single_text'))
            ->add('unitPrice',     NumberType::class, array('label'=>"Prix de l'heure"))
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Flight'
        ));
    }

}
