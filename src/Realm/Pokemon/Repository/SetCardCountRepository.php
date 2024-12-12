<?php

namespace Tgc\Realm\Pokemon\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Tgc\Realm\Pokemon\Entity\SetCardCount;

/**
 * @extends ServiceEntityRepository<SetCardCount>
 */
class SetCardCountRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SetCardCount::class);
    }
}