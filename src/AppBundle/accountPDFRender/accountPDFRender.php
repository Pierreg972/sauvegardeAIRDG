<?php

namespace AppBundle\accountPDFRender;

use AppBundle\Entity\accountStatement;
use AppBundle\Entity\Facture;
use AppBundle\Entity\TypeFacture;
use Symfony\Component\HttpFoundation\Response;
use Dompdf\Dompdf;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Dompdf\Options;
use Symfony\Component\Templating\EngineInterface;

class accountPDFRender
{
    /**
     * @var EngineInterface
     */
    private $engine;

    /**
     * accountPDFRender constructor.
     * @param EngineInterface $engine
     */
    public function __construct(EngineInterface $engine)
    {
        $this->engine = $engine;
    }

    /**
     * Renvoie le form correspondant à l'extrait de compte demandé
     *
     * @param accountStatement $accountStatement
     * @return Response $response
     */
    public function renderPDF(accountStatement $accountStatement)
    {
        $dompdf = new Dompdf(
            (new Options())
                ->set('enable_remote', true)
        );
        $dompdf->setPaper('A4', 'portrait');
        $html = $this->engine->render('pdfAccountStatement.html.twig', array('accountStatement' => $accountStatement, 'factures' => $accountStatement->getFactures(), 'client' => $accountStatement->getClient()));
        $dompdf->loadHtml($html);
        $dompdf->render();
        $response = new Response($dompdf->output());
        $response->headers->add(
            array(
                'Content-Type' => 'application/pdf',
                'X-Robots-Tag' => 'noindex',
                'Content-Disposition' => $response->headers->makeDisposition(
                    ResponseHeaderBag::DISPOSITION_INLINE,
                    'Extrait de compte n '.$accountStatement->getId().'.pdf'
                ),
            )
        );
        return $response;
    }
}