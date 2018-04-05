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
     * @Assert\Range(min=0, minMessage="Le prix unitaire saisi est trop bas.")
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
     * @ORM\Column(name="quantity", type="integer", nullable=true)
     */
    private $quantity;


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
        $diff = $this->getStartDate()->diff($this->getEndDate())->days;
        $this->setQuantity($diff);
        $this->setTotalPrice($this->getUnitPrice()*$diff/28);
    }

    /**
     * @ORM\PreRemove
     */
    public function entityDeletion(){

    }

    /**
     * @Assert\IsTrue(message="Vérifiez que les dates saisies sont valides !")
     */
    public function isDateTrue(){
        if($this->startDate < $this->endDate){
            return true;
        }
        else return false;
    }

    public function __construct()
    {
        $this->startDate = new \DateTime('01-01-2018');
        $this->endDate = new \DateTime('02-02-2018');
    }
}
