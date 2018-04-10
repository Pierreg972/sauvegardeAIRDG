<?php
/**
 * Created by PhpStorm.
 * User: Pierre
 * Date: 04/04/2018
 * Time: 14:47
 */

namespace AppBundle\Controller;


use AppBundle\Entity\ContentPrestation;
use AppBundle\Entity\Facture;
use AppBundle\Form\ContentPrestationType;
use AppBundle\formRender\formRender;
use AppBundle\PDFRender\PDFRender;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AdminController;


class FactureController extends AdminController
{
    /**
     * @var PDFRender
     */
    private $PDFRender;
    private $formRender;

    /**
     * FactureController constructor.
     * @param PDFRender $PDFRender
     * @param formRender $formRender
     */
    public function __construct(PDFRender $PDFRender, formRender $formRender)
    {

        $this->PDFRender = $PDFRender;
        $this->formRender = $formRender;
    }

    public function remplirFactureAction(){
        $form = $this->formRender->renderForm($this->request);
        if($form != null){
            $response = $this->render('@EasyAdmin/default/new.html.twig', array('form'=> $form->createView(),));
            return $response;
        }
        return parent::redirectToBackendHomepage();
    }

    public function generatePDFAction(){
        /** @var Facture $facture */
        $facture = $this->request->attributes->get('easyadmin')['item'];
        $response = $this->PDFRender->renderPDF($facture);
        return $response;

    }

}

