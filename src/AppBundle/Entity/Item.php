<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Item
 *
 * @ORM\Table(name="item")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ItemRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Item
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
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\maintenanceItem", inversedBy="items")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\Valid()
     */
    private $maintenanceItem;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     * @Assert\NotBlank()
     *
     */
    private $name;

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
     * Set name
     *
     * @param string $name
     *
     * @return Item
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
     * Set unitPrice
     *
     * @param float $unitPrice
     *
     * @return Item
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
     * Set maintenanceItem
     *
     * @param \AppBundle\Entity\maintenanceItem $maintenanceItem
     *
     * @return Item
     */
    public function setMaintenanceItem(maintenanceItem $maintenanceItem = null)
    {
        $this->maintenanceItem = $maintenanceItem;

        return $this;
    }

    /**
     * Get maintenanceItem
     *
     * @return \AppBundle\Entity\maintenanceItem
     */
    public function getMaintenanceItem()
    {
        return $this->maintenanceItem;
    }

    /**
     * Set quantity
     *
     * @param float $quantity
     *
     * @return Item
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
     * @return Item
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
        return $this->getName();
    }

    /**
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function entityCompletion()
    {
        $total = $this->getQuantity() * $this->getUnitPrice();
        $this->setTotalPrice($total);
        $this->maintenanceItem->getFacture()->setTotalPrice();
    }
}
