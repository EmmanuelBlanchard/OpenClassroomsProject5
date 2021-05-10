<?php

namespace App\Repository;

use App\Entity\Book;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method Book|null find($id, $lockMode = null, $lockVersion = null)
 * @method Book|null findOneBy(array $criteria, array $orderBy = null)
 * @method Book[]    findAll()
 * @method Book[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BookRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry, PaginatorInterface $paginator)
    {
        parent::__construct($registry, Book::class);
        $this->paginator = $paginator;
    }

    /**
     * Returns all books per page
     * @return void
     */
    public function getPaginatedBooks($page, $limit, $user, $filters = null)
    {
        $query = $this->createQueryBuilder('b')
            ->where('b.active = 1')
            ->andWhere('b.exchangeRequest = 0')
            ->andWhere('b.user <> :user')
            ->setParameter('user', $user);
        
        //On filtre les données
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

        //On filtre les données
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
            ->setMaxResults(10)
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
            ->setMaxResults(10)
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
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * Search for books according to the form
     * @return void
     */
    public function search($words = null, $category = null)
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

        return $query->getQuery()->getResult();
    }

    /**
     * Retrieves books related to a search
     *
     * @return PaginatorInterface
     */
    public function findSearch($words = null, $category = null): PaginatorInterface
    {
        $query = $this->createQueryBuilder('b');
        $query->where('b.active = 1');
        $query->andWhere('b.exchangeRequest = 0');

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

        $query = $query->getQuery();
        return $this->paginator->paginate(
            $query,
            1,
            12
        );
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
