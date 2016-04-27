<?php

namespace ContactBundle\Entity;

use ContactBundle\Entity\Contact;
use ContactBundle\Entity\ContactGroup;
use Doctrine\Common\Collections\ArrayCollection;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser {
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\OneToMany(targetEntity="Contact", mappedBy="user")
     */
    private $contacts;

    /**
     * @ORM\OneToMany(targetEntity="ContactGroup", mappedBy="user")
     */
    private $contactGroups;

    public function __construct() {
        parent::__construct();
        $this->contacts = new ArrayCollection();
        $this->contactGroups = new ArrayCollection();
    }

    /**
     * Add contacts
     *
     * @param Contact $contacts
     * @return User
     */
    public function addContact(Contact $contacts)
    {
        $this->contacts[] = $contacts;

        return $this;
    }

    /**
     * Remove contacts
     *
     * @param Contact $contacts
     */
    public function removeContact(Contact $contacts)
    {
        $this->contacts->removeElement($contacts);
    }

    /**
     * Get contacts
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getContacts()
    {
        return $this->contacts;
    }

    /**
     * Add contactGroups
     *
     * @param ContactGroup $contactGroups
     * @return User
     */
    public function addContactGroup(ContactGroup $contactGroups)
    {
        $this->contactGroups[] = $contactGroups;

        return $this;
    }

    /**
     * Remove contactGroups
     *
     * @param ContactGroup $contactGroups
     */
    public function removeContactGroup(ContactGroup $contactGroups)
    {
        $this->contactGroups->removeElement($contactGroups);
    }

    /**
     * Get contactGroups
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getContactGroups()
    {
        return $this->contactGroups;
    }
}
