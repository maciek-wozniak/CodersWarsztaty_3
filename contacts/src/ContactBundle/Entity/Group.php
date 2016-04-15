<?php

namespace ContactBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinTable;

/**
 * Groups
 *
 * @ORM\Table()
 * @ORM\Entity()
 */
class Group {
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
     * @ORM\ManyToMany(targetEntity="Contact", inversedBy="groups")
     * @ORM\JoinTable(name="contacts_groups")
     */
    private $contacts;


    /**
     * Get id
     *
     * @return integer
     */
    public function getId() {
        return $this->id;
    }

    public function __construct() {
        $this->contacts = new ArrayCollection();
    }


    /**
     * Set name
     *
     * @param string $name
     * @return Groups
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
     * Set contacts
     *
     * @return Groups
     */
    public function addContact(Contact $contact) {
        $this->contacts[] = $contact;

        return $this;
    }

    /**
     * Get contacts
     *
     * @return string
     */
    public function getContacts() {
        return $this->contacts;
    }
}
