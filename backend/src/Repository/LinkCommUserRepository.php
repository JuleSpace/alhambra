<?php
namespace App\Repository;

use App\Entity\LinkCommUser;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class LinkCommUserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LinkCommUser::class);
    }

    /**
     * Récupère toutes les commissions associées à un utilisateur donné.
     *
     * @param int $userId
     * @return array
     */
    public function findCommissionsByUserId(int $userId): array
    {
        return $this->createQueryBuilder('link')
            ->join('link.commission', 'commission')
            ->where('link.utilisateur = :userId')
            ->setParameter('userId', $userId)
            ->select('commission')
            ->getQuery()
            ->getResult();
    }
}
