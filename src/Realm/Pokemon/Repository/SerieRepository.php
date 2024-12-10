<?php

namespace Tgc\Realm\Pokemon\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Tgc\Realm\Pokemon\Entity\Serie;

/**
 * @extends ServiceEntityRepository<Serie>
 */
class SerieRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Serie::class);
    }

    public function findAllFromLocale(string $locale): array
    {
        return $this->createQueryBuilder('s')
            ->innerJoin('s.translations', 't')
            ->where('t.locale = :locale')
            ->orderBy('t.name', 'ASC')
            ->setParameter('locale', $locale)
            ->getQuery()
            ->getResult();
    }
}