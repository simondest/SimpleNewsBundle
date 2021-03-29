<?php
namespace Vertacoo\SimpleNewsBundle\Doctrine;

use Doctrine\ORM\EntityManagerInterface;
use Vertacoo\SimpleNewsBundle\Model\NewsInterface;

class NewsManager
{

    protected $objectManager;

    protected $class;

    protected $repository;

    protected $domainsConfig;


    public function __construct(EntityManagerInterface $object_manager, $domainsConfig)
    {
        $this->objectManager = $object_manager;
        
        $this->domainsConfig = $domainsConfig;
    }

    public function setClass($domain)
    {
        $class = $this->domainsConfig[$domain]['entity'];

        $this->repository = $this->objectManager->getRepository($class);
        $this->class = $this->objectManager->getClassMetadata($class)->getName();
    }

    public function create()
    {
        $news = $this->build();
        $this->persist($news);
        return $news;
    }

    public function build()
    {
        $news = new $this->class();
        return $news;
    }

    public function update(NewsInterface $news)
    {
        $news->setUpdatedAt(new \DateTime());
        $this->objectManager->flush();
        return $news;
    }

    public function persist(NewsInterface $news)
    {
        $this->objectManager->persist($news);
        $this->objectManager->flush();
        return $news;
    }

    public function remove(NewsInterface $news)
    {
        $this->objectManager->remove($news);
        $this->objectManager->flush();
        return $news;
    }

    public function refresh(NewsInterface $news)
    {
        $this->objectManager->refresh($news);
        return $news;
    }

    public function find($id)
    {
        return $this->repository->find($id);
    }

    public function findBy($filters = array(), $order = array())
    {
        return $this->repository->findBy($filters, $order);
    }

    public function findOne()
    {
        $news = $this->repository->findAll();
        if($news){
            return $news[0];
        }
        else{
            return;
        }
    }

    public function findAll()
    {
        return $this->repository->findAll();
    }

    public function getClass()
    {
        return $this->class;
    }
}

