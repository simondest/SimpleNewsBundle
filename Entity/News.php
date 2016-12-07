<?php
namespace Vertacoo\SimpleNewsBundle\Entity;

use Vertacoo\SimpleNewsBundle\Model\NewsInterface;

class News implements NewsInterface 
{
    protected $createdAt;

    protected $updatedAt;

    protected $domain;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
    }

   
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTime $created_at)
    {
        $this->createdAt = $created_at;
        return $this;
    }

    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTime $updated_at)
    {
        $this->updatedAt = $updated_at;
        return $this;
    }

    public function getDomain()
    {
        return $this->domain;
    }

    public function setDomain($domain)
    {
        $this->domain = $domain;
        return $this;
    }
}


