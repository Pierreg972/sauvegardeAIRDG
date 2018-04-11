<?php

namespace AppBundle\formRender;

use AppBundle\Entity\Facture;
use AppBundle\Entity\ContentPrestation;
use AppBundle\Form\collectionFlightType;
use AppBundle\Form\facturePrestaType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\DependencyInjection\ContainerInterface as Container;

class formRender{

    /**
     * @var Container
     */
    private $container;

    /**
     * formRender constructor.
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
            case 'prestation':
                $form = $this->container->get('form.factory')->create(facturePrestaType::class, $facture);
                $response = $form;
                $form->handleRequest($request);
                if ($form->isSubmitted() && $form->isValid()) {
                    $em = $this->container->get('doctrine')->getManager();
                    $em->flush();
                    $this->container->get('session')->getFlashBag()->add('info', "Prestation correctement ajoutée à la facture !");
                    return null;
                }
                break;
            case 'temps de vol':
                $form = $this->container->get('form.factory')->create(collectionFlightType::class, $facture);
                $response = $form;
                $form->handleRequest($request);
                if ($form->isSubmitted() && $form->isValid()) {
                    $em = $this->container->get('doctrine')->getManager();
                    $em->flush();
                    $this->container->get('session')->getFlashBag()->add('info', "Vols correctement ajoutés à la facture !");
                    return null;
                }
                break;
            default:
                $this->container->get('session')->getFlashBag()->add('info', "Bouton indisponible pour le moment.");
                $response = null;
                break;
        }
        return $response;
    }


}