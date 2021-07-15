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
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Book::class);
    }
    
    /**
     * Returns all books per page
     * @return Book[] Returns an array of Book objects
     */
    public function getPaginatedBooks($page, $limit, $user)
    {
        $query = $this->createQueryBuilder('b')
            ->where('b.active = 1')
            ->andWhere('b.exchangeRequest = 0')
            ->andWhere('b.user <> :user')
            ->setParameter('user', $user);
        
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
    public function getTotalBooksActiveWithoutExchangeRequestNotOwnedByUser($user)
    {
        $query = $this->createQueryBuilder('b')
            ->select('COUNT(b)')
            ->where('b.active = 1')
            ->andWhere('b.exchangeRequest = 0')
            ->andWhere('b.user <> :user')
            ->setParameter('user', $user);

        return $query->getQuery()->getSingleScalarResult();
    }

    /**
     * Returns all books per page
     * @return Book[] Returns an array of Book objects
     */
    public function getPaginatedBooksNoUser($page, $limit)
    {
        $query = $this->createQueryBuilder('b')
            ->where('b.active = 1')
            ->andWhere('b.exchangeRequest = 0');

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
    public function getTotalBooksActiveWithoutExchangeRequest()
    {
        $query = $this->createQueryBuilder('b')
            ->select('COUNT(b)')
            ->where('b.active = 1')
            ->andWhere('b.exchangeRequest = 0');

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
     * @return int
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
    public function findBooksActiveWithoutExchangeRequestNotOwnedByUserOfAuthor($page, $limit, $user, $author): array
    {
        $query = $this->createQueryBuilder('b')
            ->where('b.active = 1')
            ->andWhere('b.exchangeRequest = 0')
            ->andWhere('b.user <> :user')
            ->setParameter('user', $user)
            ->andWhere('b.author = :author')
            ->setParameter('author', $author)
            ->orderBy('b.createdAt', 'DESC')
            ->setFirstResult(($page * $limit) - $limit)
            ->setMaxResults($limit)
        ;
        return $query->getQuery()->getResult();
    }

    /**
     * Returns number of books active owned by user with order created at desc
     * @return int
     */
    public function getTotalBooksActiveWithoutExchangeRequestNotOwnedByUserOfAuthor($user, $author): int
    {
        $query = $this->createQueryBuilder('b')
            ->select('COUNT(b)')
            ->where('b.active = 1')
            ->andWhere('b.exchangeRequest = 0')
            ->andWhere('b.user <> :user')
            ->setParameter('user', $user)
            ->andWhere('b.author = :author')
            ->setParameter('author', $author)
        ;
        return $query->getQuery()->getSingleScalarResult();
    }

    /**
    * @return Book[] Returns an array of Book objects
    */
    public function findBooksActiveWithExchangeRequestRequestedByUser($page, $limit, $user): array
    {
        $query = $this->createQueryBuilder('b')
            ->where('b.active = 1')
            ->andWhere('b.exchangeRequest = 1')
            ->andWhere('b.userexchange = :user')
            ->setParameter('user', $user)
            ->orderBy('b.exchangeRequestAt', 'DESC')
            ->setFirstResult(($page * $limit) - $limit)
            ->setMaxResults($limit)
        ;
        return $query->getQuery()->getResult();
    }

    /**
     * Returns number of books active with exchange request requested by user
     * @return int
     */
    public function getTotalBooksActiveWithExchangeRequestRequestedByUser($user): int
    {
        $query = $this->createQueryBuilder('b')
            ->select('COUNT(b)')
            ->where('b.active = 1')
            ->andWhere('b.exchangeRequest = 1')
            ->andWhere('b.userexchange = :user')
            ->setParameter('user', $user)
        ;
        return $query->getQuery()->getSingleScalarResult();
    }

    /**
    * @return Book[] Returns an array of Book objects
    */
    public function findBooksActiveWithExchangeRequestOwnedByUser($page, $limit, $user): array
    {
        $query = $this->createQueryBuilder('b')
            ->where('b.active = 1')
            ->andWhere('b.exchangeRequest = 1')
            ->andWhere('b.user = :user')
            ->setParameter('user', $user)
            ->orderBy('b.exchangeRequestAt', 'DESC')
            ->setFirstResult(($page * $limit) - $limit)
            ->setMaxResults($limit)
        ;
        return $query->getQuery()->getResult();
    }

    /**
     * Returns number of books active with exchange request owned by user
     * @return int
     */
    public function getTotalBooksActiveWithEchangeRequestOwnedByUser($user)
    {
        $query = $this->createQueryBuilder('b')
            ->select('COUNT(b)')
            ->where('b.active = 1')
            ->andWhere('b.exchangeRequest = 1')
            ->andWhere('b.user = :user')
            ->setParameter('user', $user)
        ;
        return $query->getQuery()->getSingleScalarResult();
    }

    /**
     * Search for books by title entered in the search bar
     * @return null|array
     */
    public function search(string $search, int $limit=5): ?array
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.title LIKE :search')
            ->setParameter('search', '%'.$search.'%')
            ->setMaxResults($limit)
            ->getQuery()
            ->execute();
    }

    /**
     * Search for books by author entered in the search bar
     * @return null|array
     */
    public function searchByAuthor(string $search, int $limit=5): ?array
    {
        return $this->createQueryBuilder('b')
            ->innerJoin('b.author', 'a')
            ->andWhere('a.name LIKE :search')
            ->setParameter('search', '%'.$search.'%')
            ->setMaxResults($limit)
            ->getQuery()
            ->execute();
    }

    /**
     * Search for books by user entered in the search bar
     * @return null|array
     */
    public function searchByUser(string $search, int $limit=5): ?array
    {
        return $this->createQueryBuilder('b')
            ->innerJoin('b.user', 'u')
            ->andWhere('u.pseudo LIKE :search')
            ->setParameter('search', '%'.$search.'%')
            ->setMaxResults($limit)
            ->getQuery()
            ->execute();
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
