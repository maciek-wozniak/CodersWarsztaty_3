<?php

namespace ContactBundle\Entity;

use Doctrine\ORM\EntityRepository;

Class ContactGroupRepository extends EntityRepository {

    public function findByUser($id) {
        return $this->getEntityManager()->createQuery(
            'SELECT cg FROM ContactBundle:ContactGroup cg WHERE cg.user = :id '
        )->setParameter('id', $id)->getResult();
    }

}