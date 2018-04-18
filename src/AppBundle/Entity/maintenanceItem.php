<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * maintenanceItem
 *
 * @ORM\Table(name="maintenance_item")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\maintenanceItemRepository")
 */
class maintenanceItem
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
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Facture", inversedBy="maintenanceItems")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\Valid()
     */
    protected $facture;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=true)
     */
    private $name;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Item", mappedBy="maintenanceItem", cascade={"all"}, orphanRemoval=true)
     * @Assert\Valid()
     */
    public $items;

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
     * Set facture
     *
     * @param \AppBundle\Entity\Facture $facture
     *
     * @return maintenanceItem
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

    /**
     * Set name
     *
     * @param string $name
     *
     * @return maintenanceItem
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

    public function getItems()
    {
        return $this->items;
    }

    public function addItem(Item $item)
    {
        $this->items[] = $item;
        $item->setMaintenanceItem($this);
    }

    public function removeItem(Item $item)
    {
        $this->items->removeElement($item);
        $item->setMaintenanceItem(null);
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->items = new \Doctrine\Common\Collections\ArrayCollection();
    }
    public function __toString()
    {
        return $this->getName();
    }

}
