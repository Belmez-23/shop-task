<?php

namespace App\Service\Good;

use App\Entity\Good;
use App\Service\Good\GetGoodsInterface;
use Doctrine\ORM\EntityManagerInterface;

class GetGoodsService implements GetGoodsInterface
{
    private EntityManagerInterface $em;
    private \App\Repository\GoodRepository $repo;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->em = $entityManager;
        $this->repo = $entityManager->getRepository(Good::class);
    }

    /**
     * @inheritDoc
     */
    public function getGoods(int $page, int $limit, ?string $name = null): ?array
    {
        $qb = $this->repo->createQueryBuilder('g')
            ->orderBy('g.createdAt', 'DESC');
        if ($name) {
            $qb->andWhere('g.name LIKE :name')
                ->setParameter('name', '%'.$name.'%');
        }

        return $qb->setFirstResult(($page - 1) * $limit)->setMaxResults($limit)->getQuery()->getResult();
    }

    public function getGoodsCount(?string $name = null): int
    {
        $qb = $this->repo->createQueryBuilder('g')
            ->select('COUNT(g.id)');
        if ($name) {
            $qb->andWhere('g.name LIKE :name')
                ->setParameter('name', '%'.$name.'%');
        }

        return $qb->getQuery()->getSingleScalarResult() ?: 0;
    }

    public function getGoodById(int $id): ?Good
    {
        return $this->repo->find($id);
    }
}