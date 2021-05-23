<?php

namespace App\Repository;

use App\Entity\Book;
use InvalidArgumentException;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method Book|null find($id, $lockMode = null, $lockVersion = null)
 * @method Book|null findOneBy(array $criteria, array $orderBy = null)
 * @method Book[]    findAll()
 * @method Book[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BookRepository extends ServiceEntityRepository
{
    public const PAGINATOR_PER_PAGE = 10;
    
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Book::class);
    }
    
    /**
     * Returns all books per page
     * @return Paginator
     */
    public function getBookPaginator($user, int $page, int $nbMaxPerPage, int $offset): Paginator
    {
        if (!is_numeric($page)) {
            throw new InvalidArgumentException(
                'La valeur de l\'argument $page est incorrecte (valeur : ' . $page . ').'
            );
        }

        if ($page < 1) {
            throw new NotFoundHttpException('La page demandée n\'existe pas');
        }

        if (!is_numeric($nbMaxPerPage)) {
            throw new InvalidArgumentException(
                'La valeur de l\'argument $nbMaxPerPage est incorrecte (valeur : ' . $nbMaxPerPage . ').'
            );
        }

        $query = $this->createQueryBuilder('b')
            ->where('b.active = 1')
            ->andWhere('b.exchangeRequest = 0')
            ->andWhere('b.user <> :user')
            ->setParameter('user', $user)
            ->orderBy('b.createdAt', 'DESC')
            ->setMaxResults(self::PAGINATOR_PER_PAGE)
            ->setFirstResult($offset)
            ->getQuery()
        ;

        return new Paginator($query);
    }

    /**
     * Returns all books per page
     * @return Book[] Returns an array of Book objects
     */
    public function getPaginatedBooksNoUser($page, $limit, $filters = null)
    {
        $query = $this->createQueryBuilder('b')
            ->where('b.active = 1')
            ->andWhere('b.exchangeRequest = 0');
        
        //We filter the data
        if ($filters != null) {
            $query->andWhere('b.category IN(:category)')
                ->setParameter('category', array_values($filters));
        }
        
        $query->orderBy('b.createdAt', 'DESC')
            ->setFirstResult(($page * $limit) - $limit)
            ->setMaxResults($limit)
        ;
        return $query->getQuery()->getResult();
    }

    /**
     * Returns number of books active without exchange request
     * @return int
     */
    public function getTotalBooksActiveWithoutExchangeRequest($filters = null)
    {
        $query = $this->createQueryBuilder('b')
            ->select('COUNT(b)')
            ->where('b.active = 1')
            ->andWhere('b.exchangeRequest = 0');

        //We filter the data
        if ($filters != null) {
            $query->andWhere('b.category IN(:category)')
                ->setParameter('category', array_values($filters));
        }

        return $query->getQuery()->getSingleScalarResult();
    }

    /**
     * Returns all books per page
     * @return Book[] Returns an array of Book objects
     */
    public function getPaginatedBooks($page, $limit, $user, $filters = null)
    {
        $query = $this->createQueryBuilder('b')
            ->where('b.active = 1')
            ->andWhere('b.exchangeRequest = 0')
            ->andWhere('b.user <> :user')
            ->setParameter('user', $user);
        
        //We filter the data
        if ($filters != null) {
            $query->andWhere('b.category IN(:category)')
                ->setParameter('category', array_values($filters));
        }
        
        $query->orderBy('b.createdAt', 'DESC')
            ->setFirstResult(($page * $limit) - $limit)
            ->setMaxResults($limit)
        ;
        return $query->getQuery()->getResult();
    }

    /**
     * Returns number of books active without exchange request not owned by user
     * @return int
     */
    public function getTotalBooksActiveWithoutExchangeRequestNotOwnedByUser($user, $filters = null)
    {
        $query = $this->createQueryBuilder('b')
            ->select('COUNT(b)')
            ->where('b.active = 1')
            ->andWhere('b.exchangeRequest = 0')
            ->andWhere('b.user <> :user')
            ->setParameter('user', $user);

        //We filter the data
        if ($filters != null) {
            $query->andWhere('b.category IN(:category)')
                ->setParameter('category', array_values($filters));
        }

        return $query->getQuery()->getSingleScalarResult();
    }
    
    /**
    * @return Book[] Returns an array of Book objects
    */
    public function findBooksActiveOwnedByUserWithOrderCreatedAtDesc($page, $limit, $user)
    {
        $query = $this->createQueryBuilder('b')
            ->where('b.active = 1')
            ->andWhere('b.user = :user')
            ->setParameter('user', $user)
            ->orderBy('b.createdAt', 'DESC')
            ->setFirstResult(($page * $limit) - $limit)
            ->setMaxResults($limit)
        ;
        return $query->getQuery()->getResult();
    }
    
    /**
     * Returns number of books active owned by user with order created at desc
     * @return void
     */
    public function getTotalBooksActiveOwnedByUserWithOrderCreatedAtDesc($user)
    {
        $query = $this->createQueryBuilder('b')
            ->select('COUNT(b)')
            ->where('b.active = 1')
            ->andWhere('b.user = :user')
            ->setParameter('user', $user)
        ;
        return $query->getQuery()->getSingleScalarResult();
    }

    /**
    * @return Book[] Returns an array of Book objects
    */
    public function findBooksActiveWithoutExchangeRequestNotOwnedByUser($user)
    {
        return $this->createQueryBuilder('b')
            ->where('b.active = 1')
            ->andWhere('b.exchangeRequest = 0')
            ->andWhere('b.user <> :user')
            ->setParameter('user', $user)
            ->orderBy('b.createdAt', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }

    /**
    * @return Book[] Returns an array of Book objects
    */
    public function findBooksActiveWithExchangeRequestRequestedByUser($user)
    {
        return $this->createQueryBuilder('book')
            ->where('book.active = 1')
            ->andWhere('book.exchangeRequest = 1')
            ->andWhere('book.userexchange = :user')
            ->setParameter('user', $user)
            ->orderBy('book.exchangeRequestAt', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }

    /**
    * @return Book[] Returns an array of Book objects
    */
    public function findBooksActiveWithExchangeRequestOwnedByUser($user)
    {
        return $this->createQueryBuilder('book')
            ->where('book.active = 1')
            ->andWhere('book.exchangeRequest = 1')
            ->andWhere('book.user = :user')
            ->setParameter('user', $user)
            ->orderBy('book.exchangeRequestAt', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * Search for books according to the form
     * @return void
     */
    public function search($page, $limit, $words = null, $category = null)
    {
        $query = $this->createQueryBuilder('book');
        $query->where('book.active = 1');
        $query->andWhere('book.exchangeRequest = 0');

        if ($words != null) {
            $query->andWhere('MATCH_AGAINST(book.title, book.summary) AGAINST
            (:words boolean)>0')
                ->setParameter('words', $words);
        }
        if ($category != null) {
            $query->leftJoin('book.category', 'c');
            $query->andWhere('c.id = :id')
                ->setParameter('id', $category);
        }

        $query->orderBy('book.createdAt', 'DESC')
            ->setFirstResult(($page * $limit) - $limit)
            ->setMaxResults($limit)
        ;

        return $query->getQuery()->getResult();
    }

    /**
     * Returns the number of books retrieved by the full text search
     * @return int
     */
    public function getTotalNumberBooksInSearch($words = null, $category = null)
    {
        $query = $this->createQueryBuilder('b')
            ->select('COUNT(b)')
            ->where('b.active = 1')
            ->andWhere('b.exchangeRequest = 0');

        if ($words != null) {
            $query->andWhere('MATCH_AGAINST(b.title, b.summary) AGAINST
            (:words boolean)>0')
                ->setParameter('words', $words);
        }
        if ($category != null) {
            $query->leftJoin('b.category', 'c');
            $query->andWhere('c.id = :id')
                ->setParameter('id', $category);
        }

        return $query->getQuery()->getSingleScalarResult();
    }

    // /**
    //  * @return Book[] Returns an array of Book objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('b.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Book
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
