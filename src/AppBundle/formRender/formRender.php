<?php

namespace AppBundle\formRender;

use AppBundle\Entity\Facture;
use AppBundle\Entity\ContentPrestation;
use AppBundle\Form\ContentPrestationType;
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

        /**
         * @var contentPrestation $presta
         */
        $presta = $facture->getPresta();

        switch($facture->getType()){

            //Cas facture prestation
            case 'prestation':
                if($presta != null) {
                    $presta = $facture->getPresta();
                }
                else{
                    $presta = new ContentPrestation();
                }
                break;
            default:
                $this->container->get('session')->getFlashBag()->add('info', "Service indisponible pour le moment.");
                return null;
                break;
        }
        //Création d'un formulaire sur $presta avec le ContentPrestationType créé precedemment
        $form = $this->container->get('form.factory')->create(ContentPrestationType::class, $presta);

        //Check si le bouton est cliqué
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            //Allocation de la facture a la prestation
            $em = $this->container->get('doctrine')->getManager();
            $em->persist($presta);
            $facture->setPresta($presta);
            $em->flush();
            $this->container->get('session')->getFlashBag()->add('info', "Prestation correctement ajoutée à la facture !");
            return null;
        }
        $response = $form;
        return $response;
    }


}