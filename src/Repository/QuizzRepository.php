<?php

namespace App\Repository;

use App\Entity\Quizz;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use PhpParser\Node\Expr\Cast\String_;

/**
 * @extends ServiceEntityRepository<Quizz>
 *
 * @method Quizz|null find($id, $lockMode = null, $lockVersion = null)
 * @method Quizz|null findOneBy(array $criteria, array $orderBy = null)
 * @method Quizz[]    findAll()
 * @method Quizz[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class QuizzRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Quizz::class);
    }

    public function save(Quizz $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Quizz $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

   /**
    * @return Quizz[] Returns an array of Quizz objects
    */
   public function findAllByUserId($value): array
   {
       return $this->createQueryBuilder('q')
           ->andWhere('q.Author = :val')
           ->setParameter('val', $value)
           ->orderBy('q.Title', 'ASC')
           ->getQuery()
           ->getResult()
       ;
   }
   public function findAllTheme()
   {
        return $this->createQueryBuilder('q')
            ->select('q.Theme')
            ->distinct() 
            ->orderBy('q.Theme','ASC')
            ->getQuery()
            ->getScalarResult()
        ;
   }
   public function findAllDifficulty()
   {
        return $this->createQueryBuilder('q')
            ->select('q.Difficulty')
            ->distinct() 
            ->orderBy('q.Difficulty','ASC')
            ->getQuery()
            ->getScalarResult()
        ;
   }
   public function AddfiltersOnQuizz($filters): array
   {
        $qb = $this->createQueryBuilder('q');
        if (array_key_exists('theme',$filters) && $filters['theme'] !== '') {
            $qb->andWhere('q.Theme LIKE :th')
            ->setParameter('th',$filters['theme'].'%');
        }
        if (array_key_exists('difficulty',$filters) && $filters['difficulty'] !== '') {
            $qb->andWhere('q.Difficulty = :dif')
            ->setParameter('dif',$filters['difficulty']);
        }
        if (array_key_exists('author',$filters) && $filters['author'] !== '') {
            $qb->join('q.Author', 'u')
            ->andWhere('u.Pseudo LIKE :author')
            ->setParameter('author','%'.$filters['author'].'%');
        }
        return $qb->getQuery()->getResult();
    }

   public function findOneByTitle($value): ?Quizz
   {
       return $this->createQueryBuilder('q')
           ->andWhere('q.Title = :val')
           ->setParameter('val', $value)
           ->getQuery()
           ->getOneOrNullResult()
       ;
   }
}
