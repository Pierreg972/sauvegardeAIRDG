<?php

namespace AppBundle\viewRender;

use AppBundle\Entity\Facture;
use AppBundle\Entity\TypeFacture;
use AppBundle\Form\collectionFlightType;
use AppBundle\Form\collectionMaintenanceItemType;
use AppBundle\Form\facturePrestaType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\DependencyInjection\ContainerInterface as Container;

class viewRender{

    /**
     * @var Container
     */
    private $container;

    const PRESTA = ':easy_admin:presta.html.twig';
    const VOL = ':easy_admin:vol.html.twig';
    const MAINTENANCE = ':easy_admin:maintenance.html.twig';

    /**
     * collectionFormRender constructor.
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public function renderView(Request $request)
    {
        /**
         * @var Facture $facture
         */
        $facture = $request->attributes->get('easyadmin')['item'];

        switch($facture->getType()){
            case TypeFacture::PRESTA:
                $view = viewRender::PRESTA;
                break;
            case TypeFacture::VOL:
                $view = viewRender::VOL;
                break;
            case TypeFacture::MAINTENANCE:
                $view = viewRender::MAINTENANCE;
                break;
            default:
                $view = '@EasyAdmin/default/new.html.twig';
                break;
        }
        return $view;
    }


}