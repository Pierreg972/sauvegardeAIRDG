<?php

namespace AppBundle\formRender;

use AppBundle\Entity\Facture;
use AppBundle\Entity\ContentPrestation;
use AppBundle\Entity\TypeFacture;
use AppBundle\Form\collectionFlightType;
use AppBundle\Form\collectionMaintenanceItemType;
use AppBundle\Form\facturePrestaType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\DependencyInjection\ContainerInterface as Container;

class collectionFormRender{

    /**
     * @var Container
     */
    private $container;

    /**
     * collectionFormRender constructor.
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public function renderForm(Request $request)
    {
        /**
         * @var Facture $facture
         */
            $facture = $request->attributes->get('easyadmin')['item'];

        switch($facture->getType()){
            case TypeFacture::PRESTA:
                $form = $this->container->get('form.factory')->create(facturePrestaType::class, $facture);
                break;
            case TypeFacture::VOL:
                $form = $this->container->get('form.factory')->create(collectionFlightType::class, $facture);
                break;
            case TypeFacture::MAINTENANCE:
                $form = $this->container->get('form.factory')->create(collectionMaintenanceItemType::class, $facture);
                break;
            default:
                $this->container->get('session')->getFlashBag()->add('info', "Bouton indisponible pour le moment.");
                $form = null;
                break;
        }
        $response = $form;
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->container->get('doctrine')->getManager();
            $em->flush();
            return null;
        }
        return $response;
    }


}