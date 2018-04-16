<?php

namespace AppBundle\formRender;

use AppBundle\Entity\Facture;
use AppBundle\Entity\TypeFacture;
use AppBundle\Form\collectionFlightType;
use AppBundle\Form\collectionMaintenanceItemType;
use AppBundle\Form\facturePrestaType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\DependencyInjection\ContainerInterface as Container;

class accountFormRender{

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

    public function accountRenderForm(Request $request)
    {
        /**
         * @var Facture $facture
         */
        $client = $request->attributes->get('easyadmin')['item'];
        $repository = $this->container->get('doctrine')->getRepository('AppBundle:Facture');
        $factures = $repository->findBy(array('client' => $client));
        $form = $this->container->get('form.factory')->create(collectionMaintenanceItemType::class, $facture);
        $form->handleRequest($request);
        $response=$form;
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->container->get('doctrine')->getManager();
            $em->flush();
            return null;
        }
        return $response;
    }


}