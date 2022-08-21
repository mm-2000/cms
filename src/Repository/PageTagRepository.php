<?php

namespace App\Repository;

use App\Entity\PageTag;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PageTag>
 *
 * @method PageTag|null find($id, $lockMode = null, $lockVersion = null)
 * @method PageTag|null findOneBy(array $criteria, array $orderBy = null)
 * @method PageTag[]    findAll()
 * @method PageTag[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PageTagRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PageTag::class);
    }

    public function add(PageTag $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(PageTag $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findByPageId($pageId): array
    {
        $conn = $this->getEntityManager()->getConnection();
        $sql = '
        SELECT tag.name
        FROM page_tag
        INNER JOIN tag
        ON page_tag.tag_id = tag.id
        WHERE page_tag.page_id = :id;';
        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery(['id' => $pageId]);
        return $resultSet->fetchAllAssociative();
    }

//    /**
//     * @return PageTag[] Returns an array of PageTag objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?PageTag
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
