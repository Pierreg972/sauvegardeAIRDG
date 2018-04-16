<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContentPrestationType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('unitPrice',   NumberType::class, array('label'=>'Prix unitaire'))
            ->add('startDate',      DateType::class, array('label'=>'Date de départ', 'widget' => 'single_text'))
            ->add('endDate',     DateType::class, array('label'=>'Date de fin', 'widget' => 'single_text'))
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
