<?php

namespace App\Repository;

use App\Entity\Post;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class PostRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Post::class);
    }
    
    public function findAll() 
    {
       return $this->findBy(array(), array('created_at' => 'DESC')); 
    }
    
    
    /**
     * @param $title
     * @return Post[]
     */
    public function findAllByTitle($title): array
    {
       $qb = $this->createQueryBuilder('p')
            ->andWhere('p.title LIKE :title')
            ->setParameter('title', '%' . $title . '%')
            ->orderBy('p.created_at', 'DESC')
            ->getQuery();

        return $qb->execute();
    }

    /*
    public function findBySomething($value)
    {
        return $this->createQueryBuilder('p')
            ->where('p.something = :value')->setParameter('value', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */
}
