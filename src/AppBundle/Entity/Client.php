<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Client
 *
 * @ORM\Table(name="client")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ClientRepository")
 */
class Client
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
     * @ORM\Column(name="name", type="string", length=255)
     * @Assert\Length(min=3, minMessage="Veuillez renter un nom plus long.")
     */
    private $name;

    /**
     * @var int
     *
     * @ORM\Column(name="society_number", type="integer")
     * @Assert\Range(min=99999, minMessage="Veuillez saisir un numéro de société d'au minimum 6 chiffres")
     */
    private $societyNumber;

    /**
     * @var string
     *
     * @ORM\Column(name="head_office_addr", type="string", length=255)
     * @Assert\Length(min=10, minMessage="Ceci est une adresse bien courte. Essayez-en une plus longue !")
     */
    private $headOfficeAddr;

    /**
     * @var string
     *
     * @ORM\Column(name="country", type="string", length=255)
     * @Assert\Length(min=2, minMessage="Pays trop court. Veuillez saisir au moins le code pays a 2 caractères.")
     */
    private $country;

    /**
     * @var string
     *
     * @ORM\Column(name="IBAN", type="string", length=255)
     * @Assert\Length(min=16, max=16)
     */
    private $iban;

    /**
     * @var float
     *
     * @ORM\Column(name="tva_index", type="float")
     * @Assert\Range(min=0.001, minMessage="Un indice à la TVA si bas est indécent !")
     */
    private $tvaIndex;


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
     * @return Client
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->getName();
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
     * Set societyNumber
     *
     * @param integer $societyNumber
     *
     * @return Client
     */
    public function setSocietyNumber($societyNumber)
    {
        $this->societyNumber = $societyNumber;

        return $this;
    }

    /**
     * Get societyNumber
     *
     * @return int
     */
    public function getSocietyNumber()
    {
        return $this->societyNumber;
    }

    /**
     * Set headOfficeAddr
     *
     * @param string $headOfficeAddr
     *
     * @return Client
     */
    public function setHeadOfficeAddr($headOfficeAddr)
    {
        $this->headOfficeAddr = $headOfficeAddr;

        return $this;
    }

    /**
     * Get headOfficeAddr
     *
     * @return string
     */
    public function getHeadOfficeAddr()
    {
        return $this->headOfficeAddr;
    }

    /**
     * Set country
     *
     * @param string $country
     *
     * @return Client
     */
    public function setCountry($country)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * Get country
     *
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Set tvaIndex
     *
     * @param float $tvaIndex
     *
     * @return Client
     */
    public function setTvaIndex($tvaIndex)
    {
        $this->tvaIndex = $tvaIndex;

        return $this;
    }

    /**
     * Get tvaIndex
     *
     * @return float
     */
    public function getTvaIndex()
    {
        return $this->tvaIndex;
    }

    /**
     * Set iban
     *
     * @param string $iban
     *
     * @return Client
     */
    public function setIban($iban)
    {
        $this->iban = $iban;

        return $this;
    }

    /**
     * Get iban
     *
     * @return string
     */
    public function getIban()
    {
        return $this->iban;
    }
}
