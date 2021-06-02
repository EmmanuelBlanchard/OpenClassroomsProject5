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
    public function findBooksActiveWithoutExchangeRequestNotOwnedByUser($page, $limit, $user): array
    {
        $query = $this->createQueryBuilder('b')
            ->where('b.active = 1')
            ->andWhere('b.exchangeRequest = 0')
            ->andWhere('b.user <> :user')
            ->setParameter('user', $user)
            ->orderBy('b.createdAt', 'DESC')
            ->setFirstResult(($page * $limit) - $limit)
            ->setMaxResults($limit)
        ;
        return $query->getQuery()->getResult();
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
    public function findBooksActiveWithExchangeRequestOwnedByUser($user)
    {
        return $this->createQueryBuilder('b')
            ->where('b.active = 1')
            ->andWhere('b.exchangeRequest = 1')
            ->andWhere('b.user = :user')
            ->setParameter('user', $user)
            ->orderBy('b.exchangeRequestAt', 'DESC')
            ->getQuery()
            ->getResult()
        ;
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

    /**
     * Advanced search for books according to the form
     * @return void
     */
    public function advancedSearchBook($criteria)
    {
        $query = $this->createQueryBuilder('b');
        $query->where('b.active = 1');
        $query->andWhere('b.exchangeRequest = 0');

        $query->leftJoin('b.author', 'a');
        $query->andWhere('a.name = :authorName')
            ->setParameter('authorName', $criteria['author']->getName());

        $query->leftJoin('b.category', 'c');
        $query->andWhere('c.name = :categoryName')
            ->setParameter('categoryName', $criteria['category']->getName());

        $query->leftJoin('b.format', 'f');
        $query->andWhere('f.name = :formatName')
            ->setParameter('formatName', $criteria['format']->getName());

        $query->leftJoin('b.language', 'l');
        $query->andWhere('l.name = :languageName')
            ->setParameter('languageName', $criteria['language']->getName());

        $query->leftJoin('b.publisher', 'p');
        $query->andWhere('p.name = :publisherName')
            ->setParameter('publisherName', $criteria['publisher']->getName());
       
        $query->leftJoin('b.state', 's');
        $query->andWhere('s.name = :stateName')
            ->setParameter('stateName', $criteria['state']->getName());

        return $query->getQuery()->getResult();
    }

    /**
     * Retrieves books related to a search
     * @return Book[]
     */
    public function findSearch($search): array
    {
        $query = $this->createQueryBuilder('b');
        $query->select('c', 'b');
        $query->where('b.active = 1');
        $query->andWhere('b.exchangeRequest = 0');
        $query->join('b.category', 'c');
       
        if (!empty($search->q)) {
            $query = $query->andWhere('b.title LIKE :q');
            $query->setParameter('q', '%{$search->q%}');
        }
        return $query->getQuery()->getResult();
    }

    /**
     * Search for books according to the form
     * @return void|array
     */
    public function searchTest($page, $limit, $words = null, $category = null)
    {
        //dd($words, $category);

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

        $query->orderBy('b.createdAt', 'DESC')
            ->setFirstResult(($page * $limit) - $limit)
            ->setMaxResults($limit)
        ;

        return $query->getQuery()->getResult();
    }

    /**
     * Search for books by title a To z
     * @return void|array
     */
    public function searchBooksByTitleAToZ($page, $limit, $words = null)
    {
        $query = $this->createQueryBuilder('book');
        $query->where('book.active = 1');
        $query->andWhere('book.exchangeRequest = 0');

        if ($words != null) {
            $query->andWhere('book.title = :title')
                ->setParameter('title', $words);
        }

        $query->orderBy('b.createdAt', 'ASC')
            ->setFirstResult(($page * $limit) - $limit)
            ->setMaxResults($limit)
        ;

        return $query->getQuery()->getResult();
    }

    /**
     * Search for books by title z To a
     * @return void|array
     */
    public function searchBooksByTitleZToA($page, $limit, $words = null)
    {
        $query = $this->createQueryBuilder('book');
        $query->where('book.active = 1');
        $query->andWhere('book.exchangeRequest = 0');

        if ($words != null) {
            $query->andWhere('book.title = :title')
                ->setParameter('title', $words);
        }

        $query->orderBy('b.createdAt', 'DESC')
            ->setFirstResult(($page * $limit) - $limit)
            ->setMaxResults($limit)
        ;

        return $query->getQuery()->getResult();
    }

    /**
     * Search for books by author a To z
     * @return void|array
     */
    public function searchBooksByAuthorAToZ($page, $limit, $words = null, $author = null)
    {
        $query = $this->createQueryBuilder('book');
        $query->where('book.active = 1');
        $query->andWhere('book.exchangeRequest = 0');

        if ($words != null) {
            $query->andWhere('book.title = :title')
                ->setParameter('title', $words);
        }
        if ($author != null) {
            $query->leftJoin('b.author', 'a');
            $query->andWhere('a.id = :id')
                ->setParameter('id', $author);
        }

        $query->orderBy('b.createdAt', 'ASC')
            ->setFirstResult(($page * $limit) - $limit)
            ->setMaxResults($limit)
        ;

        return $query->getQuery()->getResult();
    }

    /**
     * Search for books by author z To a
     * @return void|array
     */
    public function searchBooksByAuthorZToA($page, $limit, $words = null, $author = null)
    {
        $query = $this->createQueryBuilder('book');
        $query->where('book.active = 1');
        $query->andWhere('book.exchangeRequest = 0');

        if ($words != null) {
            $query->andWhere('book.title = :title')
                ->setParameter('title', $words);
        }
        if ($author != null) {
            $query->leftJoin('b.author', 'a');
            $query->andWhere('a.id = :id')
                ->setParameter('id', $author);
        }

        $query->orderBy('b.createdAt', 'DESC')
            ->setFirstResult(($page * $limit) - $limit)
            ->setMaxResults($limit)
        ;

        return $query->getQuery()->getResult();
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
