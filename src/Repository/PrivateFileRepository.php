<?php

namespace App\Repository;

use App\Entity\Files\PrivateFile;
use Doctrine\ORM\EntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PrivateFile|null find($id, $lockMode = null, $lockVersion = null)
 * @method PrivateFile|null findOneBy(array $criteria, array $orderBy = null)
 * @method PrivateFile[]    findAll()
 * @method PrivateFile[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PrivateFileRepository extends EntityRepository
{

    public function getList($page, $interval, $userId)
    {
        $fields = array('d.id', 'd.title', 'd.description', 'd.keywords',  'd.originalName',  'd.mimeType', 'd.insertedAtTime', 'd.updatedAtTime', 'd.url' );
        $query = $this->createQueryBuilder('d')
            ->select($fields)
            ->setFirstResult($page)
            ->leftJoin('d.user', 'user')
            ->setParameter('user', $userId)
            ->andWhere("user.id = :user")
            ->setMaxResults($interval);

        return $query->getQuery()
            ->getArrayResult();
    }

    public function search($words) {
        $QueryBuilder = $this->createQueryBuilder('f')
            ->select('f');

        foreach ($words as $key => $word){
            $QueryBuilder->orWhere('f.keywords LIKE :param'.$key)->setParameter('param'.$key, '%'.$word.'%');
        }

        return $QueryBuilder->getQuery()->getArrayResult();
    }

    public function getRowCount()
    {
        return $this->createQueryBuilder('d')
            ->select('count(d.id)')
            ->getQuery()
            ->getSingleScalarResult();
    }

}
