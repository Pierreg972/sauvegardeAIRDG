<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Flight
 *
 * @ORM\Table(name="flight")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\FlightRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Flight
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
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Facture", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     * @Assert\Valid()
     */
    private $facture;

    /**
     * @var \Date
     *
     * @ORM\Column(name="departure_date", type="date")
     */
    private $departureDate;

    /**
     * @var string
     *
     * @ORM\Column(name="departure", type="string", length=255)
     * @Assert\NotBlank()
     *
     */
    private $departure;

    /**
     * @var string
     *
     * @ORM\Column(name="arrival", type="string", length=255)
     * @Assert\NotBlank()
     */
    private $arrival;

    /**
     * @var time
     *
     * @ORM\Column(name="flight_duration", type="time")
     */
    private $flightDuration;

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
     * @var float
     *
     * @ORM\Column(name="quantity", type="float")
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
     * Set departure
     *
     * @param string $departure
     *
     * @return Flight
     */
    public function setDeparture($departure)
    {
        $this->departure = $departure;

        return $this;
    }

    /**
     * Get departure
     *
     * @return string
     */
    public function getDeparture()
    {
        return $this->departure;
    }

    /**
     * Set arrival
     *
     * @param string $arrival
     *
     * @return Flight
     */
    public function setArrival($arrival)
    {
        $this->arrival = $arrival;

        return $this;
    }

    /**
     * Get arrival
     *
     * @return string
     */
    public function getArrival()
    {
        return $this->arrival;
    }

    /**
     * Set unitPrice
     *
     * @param float $unitPrice
     *
     * @return Flight
     */
    public function setUnitPrice($unitPrice)
    {
        $this->unitPrice = $unitPrice;

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
     * Set facture
     *
     * @param \AppBundle\Entity\Facture $facture
     *
     * @return Flight
     */
    public function setFacture(\AppBundle\Entity\Facture $facture = null)
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

    /**
     * Set departureDate
     *
     * @param \DateTime $departureDate
     *
     * @return Flight
     */
    public function setDepartureDate($departureDate)
    {
        $this->departureDate = $departureDate;

        return $this;
    }

    /**
     * Get departureDate
     *
     * @return \DateTime
     */
    public function getDepartureDate()
    {
        return $this->departureDate;
    }

    /**
     * Set flightDuration
     *
     * @param \DateTime $flightDuration
     *
     * @return Flight
     */
    public function setFlightDuration($flightDuration)
    {
        $this->flightDuration = $flightDuration;

        return $this;
    }

    /**
     * Get flightDuration
     *
     * @return time
     */
    public function getFlightDuration()
    {
        return $this->flightDuration;
    }

    /**
     * Set quantity
     *
     * @param float $quantity
     *
     * @return Flight
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * Get quantity
     *
     * @return float
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * Set totalPrice
     *
     * @param float $totalPrice
     *
     * @return Flight
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

    public function __toString()
    {
        return date('d-m-Y')." - ".$this->getDeparture()." à ".$this->getArrival();
    }

    /**
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function entityCompletion(){
        $seconds = $this->getFlightDuration()->getTimestamp();
        $this->setQuantity($seconds/3600);
        $total = $this->getQuantity() * $this->getUnitPrice();
        $this->setTotalPrice($total);
    }
}
