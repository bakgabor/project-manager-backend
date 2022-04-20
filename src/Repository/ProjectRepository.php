<?php

namespace App\Repository;

use App\Entity\Project;
use Doctrine\ORM\EntityRepository;

/**
 * @method Project|null find($id, $lockMode = null, $lockVersion = null)
 * @method Project|null findOneBy(array $criteria, array $orderBy = null)
 * @method Project[]    findAll()
 * @method Project[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProjectRepository  extends EntityRepository
{

    public function getList($page, $interval)
    {
        $fields = array('d.id', 'd.name', 'd.coverImage', 'd.insertedAtTime', );
        $query = $this->createQueryBuilder('d')
            ->select($fields)
            ->setFirstResult($page)
            ->setMaxResults($interval);

        return $query->getQuery()
            ->getArrayResult();
    }

    public function getMainList()
    {
        $fields = array('d.id', 'd.name', 'd.coverImage', 'd.insertedAtTime', );
        $query = $this->createQueryBuilder('d')
            ->select($fields)
            ->where('d.mainProject = 1');

        return $query->getQuery()
            ->getArrayResult();
    }

    public function getRowCount()
    {
        return $this->createQueryBuilder('d')
            ->select('count(d.id)')
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function search($words) {
        $fields = array('d.id', 'd.name', 'd.keywords', 'd.coverImage', 'd.insertedAtTime', );
        $QueryBuilder = $this->createQueryBuilder('d')
            ->select($fields);

        foreach ($words as $key => $word){
            $QueryBuilder->orWhere('d.keywords LIKE :param'.$key)->setParameter('param'.$key, '%'.$word.'%');
        }

        return $QueryBuilder->getQuery()->getArrayResult();
    }

}
