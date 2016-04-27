<?php

namespace ContactBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Address
 *
 * @ORM\Table()
 * @ORM\Entity()
 */
class Address
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="city", type="string", length=255)
     * @Assert\NotBlank()
     * @Assert\NotNull()
     * @Assert\Length(min=3, max=255)
     */
    private $city;

    /**
     * @var string
     *
     * @ORM\Column(name="street", type="string", length=255)
     * @Assert\NotBlank()
     * @Assert\NotNull()
     * @Assert\Length(min=3, max=255)
     */
    private $street;

    /**
     * @var integer
     *
     * @ORM\Column(name="house_number", type="integer")
     * @Assert\NotBlank()
     * @Assert\NotNull()
     * @Assert\GreaterThan(0)
     */
    private $houseNumber;

    /**
     * @var integer
     *
     * @ORM\Column(name="flat_number", type="integer", nullable=true)
     */
    private $flatNumber;

    /**
     * @ORM\ManyToOne(targetEntity="Contact", inversedBy="addresses")
     * @Assert\NotBlank()
     * @Assert\NotNull()
     *
     */
    private $contact;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set city
     *
     * @param string $city
     * @return Address
     */
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city
     *
     * @return string 
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set street
     *
     * @param string $street
     * @return Address
     */
    public function setStreet($street)
    {
        $this->street = $street;

        return $this;
    }

    /**
     * Get street
     *
     * @return string 
     */
    public function getStreet()
    {
        return $this->street;
    }

    /**
     * Set houseNumber
     *
     * @param integer $houseNumber
     * @return Address
     */
    public function setHouseNumber($houseNumber)
    {
        $this->houseNumber = $houseNumber;

        return $this;
    }

    /**
     * Get houseNumber
     *
     * @return integer 
     */
    public function getHouseNumber()
    {
        return $this->houseNumber;
    }

    /**
     * Set flatNumber
     *
     * @param integer $flatNumber
     * @return Address
     */
    public function setFlatNumber($flatNumber)
    {
        $this->flatNumber = $flatNumber;

        return $this;
    }

    /**
     * Get flatNumber
     *
     * @return integer 
     */
    public function getFlatNumber()
    {
        return $this->flatNumber;
    }

    public function getContact() {
        return $this->contact;
    }

    public function setContact(Contact $contact) {
        $this->contact = $contact;
    }
}
