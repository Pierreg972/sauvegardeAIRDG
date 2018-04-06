<?php

namespace AppBundle\formRender;

use AppBundle\Entity\Facture;
use Symfony\Component\Form\Extension\Core\Type\FormType;

class formRender{

    public function __construct()
    {
    }

    /**
     * Renvoie le formulaire correspondant à la facture demandée
     *
     * @param Factureure $facture
     * @return FormType $form
     */
    public function renderHtml(Facture $facture)
    {

    }


}