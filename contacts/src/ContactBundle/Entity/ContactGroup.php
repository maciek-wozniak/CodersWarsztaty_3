<?php

namespace ContactBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinTable;

/**
 * ContactGroup
 *
 * @ORM\Table()
 * @ORM\Entity()
 */
class ContactGroup {
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
     * @ORM\ManyToMany(targetEntity="Contact", mappedBy="groups")
     *
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
     * @return ContactGroup
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
     * @return ContactGroup
     */
    public function addContact(Contact $contact) {
        $this->contacts[] = $contact;
    }

    /**
     * Get contacts
     *
     * @return string
     */
    public function getContacts() {
        return $this->contacts;
    }

    public function removeContact(Contact $contact) {
        $this->contacts->removeElement($contact);
    }

}