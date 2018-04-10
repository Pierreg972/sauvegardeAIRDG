<?php

namespace AppBundle\Entity;

use AppBundle\Entity\Client;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Facture
 *
 * @ORM\Table(name="facture")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\FactureRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Facture
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
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\ContentPrestation", cascade={"remove"})
     * @ORM\JoinColumn(nullable=true, onDelete="SET NULL")
     * @Assert\Valid()
     */
    private $presta;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Flight", mappedBy="facture", cascade={"all"}, orphanRemoval=true)
     */
    private $flights;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Client")
     * @ORM\JoinColumn(nullable=true)
     * @Assert\Valid()
     */
    private $client;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\TypeFacture")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\Valid()
     */
    private $type;



    /**
     * @var \DateTime
     *
     * @ORM\Column(name="creation_date", type="date")
     */
    private $creationDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="last_update", type="date", nullable=true)
     */
    private $lastUpdate;

    /**
     * @var boolean
     *
     * @ORM\Column(name="paid", type="boolean")
     */
    private $paid;


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
     * Set creationDate
     *
     * @param \DateTime $creationDate
     *
     * @return Facture
     */
    public function setCreationDate($creationDate)
    {
        $this->creationDate = $creationDate;

        return $this;
    }

    /**
     * Get creationDate
     *
     * @return \DateTime
     */
    public function getCreationDate()
    {
        return $this->creationDate;
    }

    /**
     * Set lastUpdate
     *
     * @param \DateTime $lastUpdate
     *
     * @return Facture
     */
    public function setLastUpdate($lastUpdate)
    {
        $this->lastUpdate = $lastUpdate;

        return $this;
    }

    /**
     * Get lastUpdate
     *
     * @return \DateTime
     */
    public function getLastUpdate()
    {
        return $this->lastUpdate;
    }

    public function __construct()
  {
    // Par défaut, la date de l'annonce est la date d'aujourd'hui
    $this->creationDate = new \Datetime();
    $this->lastUpdate = new \Datetime();
    $this->flights = new ArrayCollection();
  }

    /**
     * Set client
     *
     * @param Client $client
     *
     * @return Facture
     */
    public function setClient(Client $client)
    {
        $this->client = $client;

        return $this;
    }

    /**
     * Get client
     *
     * @return Client
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * Set type
     *
     * @param \AppBundle\Entity\TypeFacture $type
     *
     * @return Facture
     */
    public function setType(\AppBundle\Entity\TypeFacture $type)
    {
        $this->type = $type;

        return $this;
    }

    public function __toString(){
        return 'Facture n°' . $this->getId().'-'.$this->getClient();
    }

    /**
     * Get type
     *
     * @return \AppBundle\Entity\TypeFacture
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @ORM\PreUpdate
     */
    public function updateDate(){
        $this->setLastUpdate(new \Datetime());
    }

    /**
     * Set presta
     *
     * @param \AppBundle\Entity\ContentPrestation $presta
     *
     * @return Facture
     */
    public function setPresta(\AppBundle\Entity\ContentPrestation $presta)
    {
        $this->presta = $presta;

        return $this;
    }

    /**
     * Get presta
     *
     * @return \AppBundle\Entity\ContentPrestation
     */
    public function getPresta()
    {
        return $this->presta;
    }

    /**
     * Set paid
     *
     * @param boolean $paid
     *
     * @return Facture
     */
    public function setPaid($paid)
    {
        $this->paid = $paid;

        return $this;
    }

    /**
     * Get paid
     *
     * @return boolean
     */
    public function getPaid()
    {
        return $this->paid;
    }

    public function addFlight(Flight $flight)
    {
        $this->flights[] = $flight;
        $flight->setFacture($this);
    }

    public function removeFlight(Flight $flight)
    {
        $this->flights->removeElement($flight);
        $flight->setFacture(null);
    }

    public function getFlights()
    {
        return $this->flights;
    }
}
