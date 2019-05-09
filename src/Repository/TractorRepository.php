<?php

namespace App\Repository;

use App\Entity\Tractor;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Tractor|null find($id, $lockMode = null, $lockVersion = null)
 * @method Tractor|null findOneBy(array $criteria, array $orderBy = null)
 * @method Tractor[]    findAll()
 * @method Tractor[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TractorRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Tractor::class);
    }
}
