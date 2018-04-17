<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * accountStatement
 *
 * @ORM\Table(name="account_statement")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\accountStatementRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class accountStatement
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
     * @var string
     *
     * @ORM\Column(name="name", type="string")
     * @Assert\NotBlank
     */
    private $name;

    /**
     * @var ArrayCollection
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Facture")
     * @Assert\Valid()
     */
    private $factures;

    /**
     * @var Client
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Client")
     */
    private $client;

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    public function addFacture(Facture $facture)
    {
        $this->factures[] = $facture;
    }

    public function removeFacture(Facture $facture)
    {
        $this->factures->removeElement($facture);
    }

    public function getFactures()
    {
        return $this->factures;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->factures = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->getName();
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return accountStatement
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set client
     *
     * @param \AppBundle\Entity\Client $client
     *
     * @return accountStatement
     */
    public function setClient(Client $client = null)
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
     * @ORM\PrePersist
     */
    public function initializeFactures()
    {
        $factures = $this->getClient()->getFactures();
        $this->factures= $factures;
    }
}
