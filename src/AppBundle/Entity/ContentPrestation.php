<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AdminController;

/**
 * ContentPrestation
 *
 * @ORM\Table(name="content_prestation")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ContentPrestationRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class ContentPrestation
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="start_date", type="date", nullable=false)
     */
    private $startDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="end_date", type="date", nullable=false)
     */
    private $endDate;

    /**
     * @var float
     *
     * @ORM\Column(name="unit_price", type="float")
     * @Assert\GreaterThan(value="0", message="Le prix unitaire saisi est trop bas.")
     */
    private $unitPrice;

    /**
     * @var float
     *
     * @ORM\Column(name="total_price", type="float")
     */
    private $totalPrice;

    /**
     * @var integer
     *
     * @ORM\Column(name="quantity", type="integer", nullable=false)
     */
    private $quantity;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Facture", inversedBy="prestas")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\Valid()
     */
    private $facture;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get quantity
     *
     * @return int
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * Set startDate
     *
     * @param \DateTime $startDate
     *
     * @return ContentPrestation
     */
    public function setStartDate($startDate)
    {
        $this->startDate = $startDate;

        return $this;
    }

    /**
     * Get startDate
     *
     * @return \DateTime
     */
    public function getStartDate()
    {
        return $this->startDate;
    }

    /**
     * Set endDate
     *
     * @param \DateTime $endDate
     *
     * @return ContentPrestation
     */
    public function setEndDate($endDate)
    {
        $this->endDate = $endDate;

        return $this;
    }

    /**
     * Get endDate
     *
     * @return \DateTime
     */
    public function getEndDate()
    {
        return $this->endDate;
    }

    /**
     * Set unitPrice
     *
     * @param float $unitPrice
     *
     * @return ContentPrestation
     */
    public function setUnitPrice($unitPrice)
    {
        $this->unitPrice = $unitPrice;

        return $this;
    }
    /**
     * Set quantity
     *
     * @param integer $quantity
     *
     * @return ContentPrestation
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * Get unitPrice
     *
     * @return float
     */
    public function getUnitPrice()
    {
        return $this->unitPrice;
    }

    /**
     * Set totalPrice
     *
     * @param float $totalPrice
     *
     * @return ContentPrestation
     */
    public function setTotalPrice($totalPrice)
    {
        $this->totalPrice = $totalPrice;

        return $this;
    }

    /**
     * Get totalPrice
     *
     * @return float
     */
    public function getTotalPrice()
    {
        return $this->totalPrice;
    }

    /**
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function entityCompletion(){
        $diff = $this->getStartDate()->diff($this->getEndDate())->days+1;
        $this->setQuantity($diff);
        $mois = date('m', date_timestamp_get($this->getStartDate()));
        $nbJour = date('t',$mois);
        $this->setTotalPrice($this->getUnitPrice()*$diff/$nbJour);
        $this->facture->setTotalPrice();
    }

    /**
     * @Assert\IsTrue(message="Vérifiez que la date de début est antérieur a la date de fin.")
     */
    public function isDateTrue(){
        if($this->startDate <= $this->endDate){
            return true;
        }
        else return false;
    }

    public function __construct()
    {
        $this->startDate = new \DateTime('01-01-2018');
        $this->endDate = new \DateTime('02-02-2018');
    }

    public function __toString()
    {
        return "Prestation n°".$this->getId();
    }

    /**
     * Set facture
     *
     * @param \AppBundle\Entity\Facture $facture
     *
     * @return ContentPrestation
     */
    public function setFacture(Facture $facture = null)
    {
        $this->facture = $facture;

        return $this;
    }

    /**
     * Get facture
     *
     * @return \AppBundle\Entity\Facture
     */
    public function getFacture()
    {
        return $this->facture;
    }
}
