<?php
/**
 * Created by PhpStorm.
 * User: Pierre
 * Date: 04/04/2018
 * Time: 14:47
 */

namespace AppBundle\Controller;


use AppBundle\Entity\Facture;
use AppBundle\Form\facturePrestaType;
use AppBundle\formRender\collectionFormRender;
use AppBundle\viewRender\viewRender;
use AppBundle\PDFRender\PDFRender;
use AppBundle\accountPDFRender\accountPDFRender;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AdminController;
use AppBundle\Entity\Testou;
use Proxies\__CG__\AppBundle\Entity\accountStatement;


class FactureController extends AdminController
{
    /**
     * @var PDFRender
     */
    private $PDFRender;
    private $collectionFormRender;
    private $viewRender;
    private $accountPDFRender;

    /**
     * FactureController constructor.
     * @param PDFRender $PDFRender
     * @param collectionFormRender $collectionFormRender
     * @param viewRender $viewRender
     * @param accountPDFRender $accountPDFRender
     */
    public function __construct(PDFRender $PDFRender, collectionFormRender $collectionFormRender, viewRender $viewRender, accountPDFRender $accountPDFRender)
    {

        $this->PDFRender = $PDFRender;
        $this->collectionFormRender = $collectionFormRender;
        $this->viewRender = $viewRender;
        $this->accountPDFRender = $accountPDFRender;
    }

    public function generateAccountPDFAction(){
        /** @var accountStatement $accountStatement */
        $accountStatement = $this->request->attributes->get('easyadmin')['item'];
        $response = $this->accountPDFRender->renderPDF($accountStatement);
        return $response;
    }

    public function remplirFactureAction(){
        $form = $this->collectionFormRender->renderForm($this->request);
        $view = $this->viewRender->renderView($this->request);
        if($form != null){
            $response = $this->render($view, array('form'=> $form->createView(),));
            return $response;
        }
        $em = $this->getDoctrine()->getManager();
        $em->flush();
        return parent::redirectToReferrer();
    }

    public function generatePDFAction(){
        /** @var Facture $facture */
        $facture = $this->request->attributes->get('easyadmin')['item'];
        $response = $this->PDFRender->renderPDF($facture);
        return $response;

    }

}

