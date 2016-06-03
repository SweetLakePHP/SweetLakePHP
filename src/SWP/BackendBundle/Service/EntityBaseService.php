<?php

namespace SWP\BackendBundle\Service;

use Doctrine\ORM\EntityManager;

abstract class EntityBaseService
{
    protected $em;
    protected $repository;
    protected $repo;

    /**
     * EntityBaseService constructor.
     *
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em)
    {
        $class        = get_class($this);
        $classExplode = explode("\\", $class);

        $repository = $classExplode[0] . $classExplode[1] . ':' . end($classExplode);
        $repository = str_replace('Service', '', $repository);
        $repo       = $em->getRepository($repository);

        $this->em         = $em;
        $this->repository = $repository;
        $this->repo       = $repo;
    }

    /**
     * @param $id
     *
     * @return mixed
     */
    public function find($id)
    {
        $findOne = $this->em
            ->getRepository($this->repository)
            ->find($id);

        return $findOne;
    }

    /**
     * @param array $criteria
     *
     * @return mixed
     */
    public function findOneBy(array $criteria)
    {
        $findOne = $this->em
            ->getRepository($this->repository)
            ->findOneBy($criteria);

        return $findOne;
    }

    /**
     * @return mixed
     */
    public function findAll()
    {
        $findAll = $this->em
            ->getRepository($this->repository)
            ->findAll();

        return $findAll;
    }

    /**
     * @param array      $criteria
     * @param array|null $orderBy
     * @param null       $limit
     *
     * @return mixed
     */
    public function findBy(array $criteria, array $orderBy = null, $limit = null)
    {
        $findBy = $this->em
            ->getRepository($this->repository)
            ->findBy($criteria, $orderBy, $limit);

        return $findBy;
    }

    /**
     * @return mixed
     */
    public function newInstance()
    {
        $entityInfo   = $this->em->getClassMetadata($this->repository);
        $entityMember = new $entityInfo->name;

        return $entityMember;
    }

    /**
     * @return mixed
     */
    public function repo()
    {
        return $this->repo;
    }
}
