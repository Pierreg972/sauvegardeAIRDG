<?php
/**
 * Created by PhpStorm.
 * User: Pierre
 * Date: 04/04/2018
 * Time: 14:47
 */

namespace AppBundle\Controller;


use AppBundle\Entity\ContentPrestation;
use AppBundle\Form\ContentPrestationType;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AdminController;
use Symfony\Component\Form\Extension\Core\Type\DateIntervalType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class FactureController extends AdminController
{
    public function remplirFactureAction(){
        //Détermination du type de facture
        $id = $this->request->query->get('id');
        $factRepository = $this->getDoctrine()->getRepository('AppBundle:Facture');
        $facture = $factRepository->find($id);
        //Récupération de la presta existante pour cette facture si elle existe
        $prestaRepository = $this->getDoctrine()->getRepository('AppBundle:ContentPrestation');
        $prestas = $prestaRepository->findBy(
            array('facture' => $facture)
        );
        if(!$prestas==null) {
            $presta = $prestas[0];
            $this->get('session')->getFlashBag()->add('info', "Vous modifiez une prestation déjà présente en base !");
        }
        else{
            $presta = new ContentPrestation();
            $presta = $presta->setStartDate(new \DateTime('01-01-2018'));
            $presta = $presta->setEndDate(new \DateTime('01-02-2018'));
        }

        switch($facture->getType()){

            //Cas facture prestation
            case 'prestation':
                //Création d'un formulaire sur $presta avec le ContentPrestationType créé precedemment
                $form = $this->get('form.factory')->create(ContentPrestationType::class, $presta);

                //Check si le bouton est cliqué
                $form->handleRequest($this->request);
                if ($form->isSubmitted() && $form->isValid()) {

                    //Allocation de la facture a la prestation
                    $presta = $presta->setFacture($facture);
                    $em = $this->getDoctrine()->getManager();
                    $em->persist($presta);
                    $em->flush();
                    $this->get('session')->getFlashBag()->clear();
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
        return new Response("On arrive ici !".$id);
    }

}

