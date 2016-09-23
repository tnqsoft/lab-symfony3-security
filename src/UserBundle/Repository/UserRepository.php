<?php

namespace UserBundle\Repository;

use Doctrine\ORM\EntityRepository;
use UserBundle\Service\PaginatorService;

/**
 * This custom Doctrine repository is empty because so far we don't need any custom
 * method to query for application user information. But it's always a good practice
 * to define a custom repository that will be used when the application grows.
 * See http://symfony.com/doc/current/book/doctrine.html#custom-repository-classes
 *
 */
class UserRepository extends EntityRepository
{
    public function getUserByResetToken($token)
    {
        return $this->createQueryBuilder('u')
            ->where('u.resetToken = :token AND u.resetTimeout > :now')
            ->setParameter('token', $token)
            ->setParameter('now', new \DateTime())
            ->getQuery()
            ->getOneOrNullResult();
    }

    /**
     * Get list by pagination
     *
     * @param integer $page
     * @param integer $limit
     * @param string $orderBy Order By Field
     * @param string $orderDir Order Direction
     * @param string $keyword Keyword for search
     * @return PaginatorService
     */
    public function getListPagination($page=1, $limit=15, $orderBy='createdAt', $orderDir='DESC', $keyword='')
    {
        $query = $this->createQueryBuilder('u')
            ->orderBy('u.'.$orderBy, $orderDir);

        if($keyword !== '') {
            $query->andWhere('u.username LIKE :keyword OR u.email LIKE :keyword')
                ->setParameter('keyword', '%'.$keyword.'%');
        }

        $dql = $query->getQuery();

        return new PaginatorService($dql, $page, $limit);
    }
}
