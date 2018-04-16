<?php
/**
 * Created by PhpStorm.
 * User: Pierre
 * Date: 04/04/2018
 * Time: 14:47
 */

namespace AppBundle\Controller;


use AppBundle\Entity\Facture;
use AppBundle\formRender\collectionFormRender;
use AppBundle\viewRender\viewRender;
use AppBundle\PDFRender\PDFRender;
use AppBundle\formRender\accountFormRender;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AdminController;


class FactureController extends AdminController
{
    /**
     * @var PDFRender
     */
    private $PDFRender;
    private $collectionFormRender;
    private $viewRender;
    private $accountFormRender;

    /**
     * FactureController constructor.
     * @param PDFRender $PDFRender
     * @param collectionFormRender $collectionFormRender
     * @param viewRender $viewRender
     * @param accountFormRender $accountFormRender
     */
    public function __construct(PDFRender $PDFRender, collectionFormRender $collectionFormRender, viewRender $viewRender, accountFormRender $accountFormRender)
    {

        $this->PDFRender = $PDFRender;
        $this->collectionFormRender = $collectionFormRender;
        $this->viewRender = $viewRender;
        $this->accountFormRender = $accountFormRender;
    }

    public function accountStatementAction(){
        $form = $this->accountFormRender->accountRenderForm($this->request);
        if($form != null){
            $response = $this->render('::accountStatement.html.twig', array('form'=> $form->createView(),));
            return $response;
        }
        return parent::redirectToReferrer();
    }

    public function remplirFactureAction(){
        $form = $this->collectionFormRender->renderForm($this->request);
        $view = $this->viewRender->renderView($this->request);
        if($form != null){
            $response = $this->render($view, array('form'=> $form->createView(),));
            return $response;
        }
        return parent::redirectToReferrer();
    }

    public function generatePDFAction(){
        /** @var Facture $facture */
        $facture = $this->request->attributes->get('easyadmin')['item'];
        $response = $this->PDFRender->renderPDF($facture);
        return $response;

    }

}

