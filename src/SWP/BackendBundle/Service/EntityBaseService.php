<?php

namespace SWP\BackendBundle\Service;

use Doctrine\ORM\EntityManager;

abstract class EntityBaseService
{
    protected $em;
    protected $repository;
    protected $repo;

    public function __construct(EntityManager $em)
    {
        $class = get_class($this);
        $classExplode = explode("\\", $class);

        $repository = $classExplode[0] . $classExplode[1] . ':' . end($classExplode);
        $repository = str_replace('Service', '', $repository);
        $repo       = $em->getRepository($repository);

        $this->em         = $em;
        $this->repository = $repository;
        $this->repo       = $repo;
    }

    public function find($id)
    {
        $findOne = $this->em
            ->getRepository($this->repository)
            ->find($id);

        return $findOne;
    }

    public function findOneBy(array $criteria)
    {
        $findOne = $this->em
            ->getRepository($this->repository)
            ->findOneBy($criteria);

        return $findOne;
    }

    public function findAll()
    {
        $findAll = $this->em
            ->getRepository($this->repository)
            ->findAll();

        return $findAll;
    }

    public function findBy(array $criteria, array $orderBy = null, $limit = null)
    {
        $findBy = $this->em
            ->getRepository($this->repository)
            ->findBy($criteria, $orderBy, $limit);

        return $findBy;
    }

    public function newInstance()
    {
        $entityInfo   = $this->em->getClassMetadata($this->repository);
        $entityMember = new $entityInfo->name;

        return $entityMember;
    }

    public function repo()
    {
        return $this->repo;
    }
}