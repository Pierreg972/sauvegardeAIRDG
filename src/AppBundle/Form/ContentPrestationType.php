<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContentPrestationType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('unitPrice',   NumberType::class, array('label'=>'Prix unitaire', 'attr' => array('class' => 'col-xs-2')))
            ->add('startDate',      DateType::class, array('label'=>'Date de départ', 'widget' => 'single_text', 'attr' => array('class' => 'col-xs-2')))
            ->add('endDate',     DateType::class, array('label'=>'Date de fin', 'html5' => false, 'widget' => 'single_text', 'attr' => array('class' => 'col-xs-2 js-datepicker')))
        ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\ContentPrestation'
        ));
    }

    public function getBlockPrefix()
    {
        return 'ContentPrestationType';
    }
}
