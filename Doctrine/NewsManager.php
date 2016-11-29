<?php
namespace Vertacoo\SimpleNewsBundle\Doctrine;

use Doctrine\Common\Persistence\ObjectManager;
use Vertacoo\SimpleNewsBundle\Model\NewsInterface;

class NewsManager
{
    protected $objectManager;
    protected $class;
    protected $repository;
    public function __construct(ObjectManager $object_manager, $class)
    {
        $this->objectManager = $object_manager;
        $this->repository = $object_manager->getRepository($class);
        $metadata = $object_manager->getClassMetadata($class);
        $this->class = $metadata->getName();
    }
    public function create($title = '', $body = '', $domain='default') {
        $news = $this->build($title, $body, $domain);
        $this->persist($news);
        return $news;
    }
    public function build($title = '', $body = '', $domain='default') {
        $news = new $this->class;
        $news->setTitle($title);
        $news->setBody($body);
        $news->setdomain($domain);
        return $news;
    }
    public function update(NewsInterface $news) {
        $news->setUpdatedAt(new \DateTime);
        $this->objectManager->flush();
        return $news;
    }
    public function persist(NewsInterface $news) {
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
    public function find($id) {
        return $this->repository->find($id);
    }
    public function findBy($filters = array(), $order = array()) {
        return $this->repository->findBy($filters, $order);
    }
    public function findOneByDomain($domain) {
        return $this->repository->findOneByDomain($domain);
    }
    public function findAll() {
        return $this->repository->findAll();
    }
    public function getClass()
    {
        return $this->class;
    }
}

