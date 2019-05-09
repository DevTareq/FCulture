<?php

namespace App\Repository;

use App\Entity\Crop;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Crop|null find($id, $lockMode = null, $lockVersion = null)
 * @method Crop|null findOneBy(array $criteria, array $orderBy = null)
 * @method Crop[]    findAll()
 * @method Crop[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CropRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Crop::class);
    }
}
