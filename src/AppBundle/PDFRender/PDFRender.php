<?php

namespace AppBundle\PDFRender;

use AppBundle\Entity\Facture;
use AppBundle\Entity\TypeFacture;
use Symfony\Component\HttpFoundation\Response;
use Dompdf\Dompdf;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Dompdf\Options;
use Symfony\Component\Templating\EngineInterface;

class PDFRender
{
    /**
     * @var EngineInterface
     */
    private $engine;

    /**
     * htmlRender constructor.
     * @param EngineInterface $engine
     */
    public function __construct(EngineInterface $engine)
    {
        $this->engine = $engine;
    }

    /**
     * Renvoie l'html correspondant à la facture demandée
     *
     * @param Facture $facture
     * @return Response $response
     */
    public function renderPDF(Facture $facture)
    {
        $dompdf = new Dompdf(
            (new Options())
                ->set('enable_remote', true)
        );
        $dompdf->setPaper('A4', 'portrait');
        switch($facture->getType()){
            //Cas facture prestation
            case TypeFacture::PRESTA:
                $html = $this->engine->render('pdfPresta.html.twig', array('facture' => $facture, 'prestas' => $facture->getPrestas(), 'client' => $facture->getClient()));
                break;
            case TypeFacture::VOL:
                $html = $this->engine->render('pdfFlights.html.twig', array('facture' => $facture, 'flights' => $facture->getFlights(), 'client' => $facture->getClient()));
                break;
            case TypeFacture::MAINTENANCE:
                $html = $this->engine->render('pdfMaintenance.html.twig', array('facture' => $facture, 'maintenanceItems' => $facture->getMaintenanceItems(), 'client' => $facture->getClient()));
                break;
            default:
                throw new \InvalidArgumentException();
        }
        $dompdf->loadHtml($html);
        $dompdf->render();
        $response = new Response($dompdf->output());
        $response->headers->add(
            array(
                'Content-Type' => 'application/pdf',
                'X-Robots-Tag' => 'noindex',
                'Content-Disposition' => $response->headers->makeDisposition(
                    ResponseHeaderBag::DISPOSITION_INLINE,
                    'Facture '.$facture->getId().'.pdf'
                ),
            )
        );
        return $response;
    }
}