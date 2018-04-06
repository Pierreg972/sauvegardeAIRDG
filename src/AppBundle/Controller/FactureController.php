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
use AppBundle\htmlRender\htmlRender;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AdminController;
use EasyCorp\Bundle\EasyAdminBundle\Router\EasyAdminRouter;
use Symfony\Component\Form\Extension\Core\Type\DateIntervalType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Dompdf\Dompdf;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Dompdf\Options;


class FactureController extends AdminController
{
    /**
     * @var htmlRender
     */
    private $htmlRender;

    /**
     * FactureController constructor.
     * @param htmlRender $htmlRender
     */
    public function __construct(htmlRender $htmlRender)
    {

        $this->htmlRender = $htmlRender;
    }

    public function remplirFactureAction(){
        /** @var Facture $facture */
        $facture = $this->request->attributes->get('easyadmin')['item'];
        switch($facture->getType()){

            //Cas facture prestation
            case 'prestation':
                if($facture->getPresta() != null) {
                    return $this->redirect(parent::generateUrl('easyadmin', array('action' => 'edit', 'entity' => 'Prestations', 'id' => $facture->getPresta()->getId())));
                }
                else{
                    $presta = new ContentPrestation();
                }
                //Création d'un formulaire sur $presta avec le ContentPrestationType créé precedemment
                $form = $this->get('form.factory')->create(ContentPrestationType::class, $presta);

                //Check si le bouton est cliqué
                $form->handleRequest($this->request);
                if ($form->isSubmitted() && $form->isValid()) {

                    //Allocation de la facture a la prestation
                    $em = $this->getDoctrine()->getManager();
                    $em->persist($presta);
                    $facture->setPresta($presta);
                    $em->flush();
                    $this->get('session')->getFlashBag()->add('info', "Prestation correctement ajoutée à la facture !");
                    return parent::redirectToBackendHomepage();
                }
                return $this->render('@EasyAdmin/default/new.html.twig', array('form' => $form->createView(),));
                break;
            case 'service':
                $this->get('session')->getFlashBag()->add('info', "Service géré.");
                return $this->redirectToBackendHomepage();
                break;
        }
    }

    public function generatePDFAction(){
        /** @var Facture $facture */
        $facture = $this->request->attributes->get('easyadmin')['item'];
        $response = $this->htmlRender->renderHtml($facture);
        return $response;

    }

}

