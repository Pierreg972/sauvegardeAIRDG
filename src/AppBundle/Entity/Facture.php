<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

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
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Client", cascade={"remove"})
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
  }

    /**
     * Set client
     *
     * @param \AppBundle\Entity\Client $client
     *
     * @return Facture
     */
    public function setClient(\AppBundle\Entity\Client $client)
    {
        $this->client = $client;

        return $this;
    }

    /**
     * Get client
     *
     * @return \AppBundle\Entity\Client
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
        return 'Facture n°' . $this->getId();
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
}
