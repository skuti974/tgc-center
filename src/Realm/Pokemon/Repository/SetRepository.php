<?php

namespace Tgc\Realm\Pokemon\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Tgc\Realm\Pokemon\Entity\Set;

/**
 * @extends ServiceEntityRepository<Set>
 */
class SetRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Set::class);
    }

    public function findOneByCodeAndLocale(string $code, string $locale): ?Set
    {
        return $this->createQueryBuilder('s')
            ->innerJoin('s.translations', 't')
            ->where('s.code = :code')
            ->andWhere('t.locale = :locale')
            ->setParameter('code', $code)
            ->setParameter('locale', $locale)
            ->getQuery()
            ->getOneOrNullResult();
    }
}