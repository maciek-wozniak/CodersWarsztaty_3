<?php

namespace ContactBundle\Entity;

use Doctrine\ORM\EntityRepository;

class ContactRepository extends EntityRepository {

    public function findContactsByName($name) {
        return $this->getEntityManager()->createQuery(
            'SELECT c FROM ContactBundle:Contact c WHERE c.name LIKE :name OR c.surname like :name'
        )->setParameter('name', '%'.$name.'%')->getResult();
    }

    public function findByUser($user) {
        return $this->getEntityManager()->createQuery(
            'SELECT c FROM ContactBundle:Contact c WHERE c.user = :user'
        )->setParameter('user', $user)->getResult();
    }

}