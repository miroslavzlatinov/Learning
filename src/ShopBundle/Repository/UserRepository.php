<?php

namespace ShopBundle\Repository;

use Symfony\Component\Security\Core\User\UserInterface;

/**
 * UserRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class UserRepository extends \Doctrine\ORM\EntityRepository
{
    /**
     * Loads the user for the given username.
     *
     * This method must return null if the user is not found.
     *
     * @param string $username The username
     *
     * @return UserInterface|null
     */
    public function loadUserByUsername($username)
    {

        $queryBuilder = $this->createQueryBuilder('u');
        $queryBuilder
            ->where($queryBuilder->expr()->eq('u.username', ':username'))
            ->orWhere($queryBuilder->expr()->eq('u.email', ':username'))
            ->setParameter(':username', $username);

        return $queryBuilder->getQuery()->getOneOrNullResult();
    }

}
