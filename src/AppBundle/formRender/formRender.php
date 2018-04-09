<?php

namespace AppBundle\formRender;

use AppBundle\Entity\Facture;
use AppBundle\Entity\ContentPrestation;
use AppBundle\Form\collectionFlightType;
use AppBundle\Form\ContentPrestationType;
use AppBundle\Form\flightType;
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
        $em = $this->container->get('doctrine')->getManager();

        switch($facture->getType()){
            case 'prestation':
                /**
                 * @var contentPrestation $presta
                 */
                $presta = $facture->getPresta();
                if($presta != null) {
                    $presta = $facture->getPresta();
                }
                else{
                    $presta = new ContentPrestation();
                }
                $form = $this->container->get('form.factory')->create(ContentPrestationType::class, $presta);
                $response = $form;
                $form->handleRequest($request);
                if ($form->isSubmitted() && $form->isValid()) {
                    $em->persist($presta);
                    $facture->setPresta($presta);
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