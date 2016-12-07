<?php
namespace Vertacoo\SimpleNewsBundle\Entity;

use Vertacoo\SimpleNewsBundle\Model\NewsInterface;

class News implements NewsInterface 
{
    protected $createdAt;

    protected $updatedAt;


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

    
    
}


