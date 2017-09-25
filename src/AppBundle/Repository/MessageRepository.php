<?php

/**
 * Created by PhpStorm.
 * User: Users CS
 * Date: 24.09.2017
 * Time: 22:20
 */
namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class MessageRepository extends EntityRepository
{
    public function selectOldMessages($count)
    {
        return $this->getEntityManager()
            ->createQuery(
                'select m.id from AppBundle:Message m ORDER BY m.id DESC'
            )
            ->setMaxResults($count)
            ->execute();
    }

    public function deleteOldMessages($ids)
    {
        return $this->getEntityManager()
            ->createQuery(
                'delete from AppBundle:Message m WHERE m.id IN (:ids)'
            )
            ->setParameter('ids', $ids)
            ->execute();
    }
}