<?php

namespace AppBundle\Form;

use Doctrine\DBAL\Types\FloatType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Component\Validator\Constraints\Time;

class flightType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('departureDate',   DateType::class, array('label'=>'Date'))
            ->add('departure',TextType::class, array('label'=>'Lieu de départ'))
            ->add('arrival',     TextType::class, array('label'=>"Lieu d'arrivée"))
            ->add('taxName',TextType::class, array('label'=>'Taxe et parking', 'required' => false))
            ->add('taxPrice',     NumberType::class, array('label'=>"Prix de la taxe", 'required' => false))
            ->add('piloteName',TextType::class, array('label'=>'Nom du pilote', 'required' => false))
            ->add('piloteFee',     NumberType::class, array('label'=>"Prix du pilote", 'required' => false))
            ->add('flightDuration',TimeType::class, array('label'=>'Durée du vol'))
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
