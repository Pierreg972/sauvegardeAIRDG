<?php

namespace AppBundle\Entity;

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
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\ContentPrestation", mappedBy="facture", cascade={"all"}, orphanRemoval=true)
     * @Assert\Valid()
     * @ORM\OrderBy({"startDate"="ASC"})
     */
    private $prestas;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Flight", mappedBy="facture", cascade={"all"}, orphanRemoval=true)
     * @Assert\Valid()
     */
    private $flights;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\maintenanceItem", mappedBy="facture", cascade={"all"}, orphanRemoval=true)
     * @Assert\Valid()
     */
    private $maintenanceItems;

    /**
     * @var string
     * @ORM\Column(name="engine_name", type="string", length=255, nullable=true)
     */
    private $engineName;

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
    public function setType(TypeFacture $type)
    {
        $this->type = $type;

        return $this;
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

    /**
     * Set engineName
     *
     * @param string $engineName
     *
     * @return Facture
     */
    public function setEngineName($engineName)
    {
        $this->engineName = $engineName;

        return $this;
    }

    /**
     * Get engineName
     *
     * @return string
     */
    public function getEngineName()
    {
        return $this->engineName;
    }

    public function addMaintenanceItem(maintenanceItem $maintenanceItem)
    {
        $this->maintenanceItems[] = $maintenanceItem;
        $maintenanceItem->setFacture($this);

        return $this;
    }

    public function removeMaintenanceItem(maintenanceItem $maintenanceItem)
    {
        $this->maintenanceItems->removeElement($maintenanceItem);
        $maintenanceItem->setFacture(null);
    }

    public function getMaintenanceItems()
    {
        return $this->maintenanceItems;
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

    public function addPresta(ContentPrestation $presta)
    {
        $this->prestas[] = $presta;
        $presta->setFacture($this);
    }

    public function removePresta(ContentPrestation $presta)
    {
        $this->prestas->removeElement($presta);
        $presta->setFacture(null);
    }

    public function getPrestas()
    {
        return $this->prestas;
    }

    public function __construct()
    {
        // Par défaut, la date de l'annonce est la date d'aujourd'hui
        $this->creationDate = new \Datetime();
        $this->lastUpdate = new \Datetime();
        $this->flights = new ArrayCollection();
        $this->prestas = new ArrayCollection();
        $this->maintenanceItems = new ArrayCollection();
    }

    public function __toString()
    {
        return 'Facture n°' . $this->getId() . '-' . $this->getClient();
    }

    /**
     * @ORM\PreFlush()
     */
    public function typeChanging()
    {
        switch ($this->getType()) {
            case TypeFacture::PRESTA:
                $this->getFlights()->clear();
                $this->getMaintenanceItems()->clear();
                $this->setEngineName(null);
                break;
            case TypeFacture::VOL:
                $this->getPrestas()->clear();
                $this->getMaintenanceItems()->clear();
                $this->setEngineName(null);
                break;
            case TypeFacture::MAINTENANCE:
                $this->getFlights()->clear();
                $this->getPrestas()->clear();
                break;
            default:
                break;
        }
    }

    /**
     * @ORM\PreUpdate
     */
    public function updateDate()
    {
        $this->setLastUpdate(new \Datetime());
    }
}
