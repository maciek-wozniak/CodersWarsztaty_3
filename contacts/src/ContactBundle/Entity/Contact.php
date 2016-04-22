<?php

namespace ContactBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Contact
 *
 * @ORM\Entity(repositoryClass="ContactBundle\Entity\ContactRepository")
 * @ORM\Table()
 */
class Contact {
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
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="surname", type="string", length=255)
     */
    private $surname;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * Array of contact addresses
     * @ORM\OneToMany(targetEntity="Address", mappedBy="contact", cascade="ALL")
     */
    private $addresses;

    /**
     * Array of contact email addresses
     * @ORM\OneToMany(targetEntity="Email", mappedBy="contact", cascade="ALL")
     */
    private $emails;

    /**
     * Array of contact phones
     * @ORM\OneToMany(targetEntity="Phone", mappedBy="contact", cascade="ALL")
     */
    private $phones;

    /**
     * Array of contact groups
     * @ORM\ManyToMany(targetEntity="ContactGroup", inversedBy="contacts")
     * @ORM\JoinTable(name="contacts_groups")
     */
    private $groups;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId() {
        return $this->id;
    }


    public function __construct() {
        $this->addresses = new ArrayCollection();
        $this->emails = new ArrayCollection();
        $this->phones = new ArrayCollection();
        $this->groups = new ArrayCollection();
    }

    public function addGroup(ContactGroup $group) {
        $this->groups[] = $group;
    }

    public function removeGroup(ContactGroup $group) {
        $this->groups->removeElement($group);
    }

    public function getGroups() {
        return $this->groups;
    }

    public function addPhone(Phone $phone) {
        $this->phones = $phone;
    }

    public function getPhones() {
        return $this->phones;
    }

    public function addEmail(Email $email) {
        $this->emails[] = $email;
    }

    public function getEmails() {
        return $this->emails;
    }

    public function addAddress(Address $address) {
        $this->addresses[] = $address;
    }

    public function getAddresses() {
        return $this->addresses;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Contact
     */
    public function setName($name) {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName() {
        return $this->name;
    }

    /**
     * Set surname
     *
     * @param string $surname
     * @return Contact
     */
    public function setSurname($surname) {
        $this->surname = $surname;

        return $this;
    }

    /**
     * Get surname
     *
     * @return string
     */
    public function getSurname() {
        return $this->surname;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Contact
     */
    public function setDescription($description) {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription() {
        return $this->description;
    }
}
