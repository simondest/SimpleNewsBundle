<?php
namespace Vertacoo\SimpleNewsBundle\Entity;

use Vertacoo\SimpleNewsBundle\Model\NewsInterface;

class News implements NewsInterface
{
    
    protected $title;

    protected $body;

    protected $createdAt;

    protected $updatedAt;

    protected $domain;

    protected $imageFileName;

    protected $image;
    
    

    public function __construct()
    {
        $this->createdAt = new \DateTime();
    }

    public function getTitle()
    {
        if(null !== $this->translate()->getTitle()){
            return $this->translate()->getTitle();
        }
        return $this->title;
    }

    public function setTitle($title)
    {
        
        $this->title = $title;
        return $this;
    }

    public function getBody()
    {
       if(null !== $this->translate()->getBody()){
           return $this->translate()->getBody();
       }
        return $this->body;
    }

    public function setBody($body)
    {
        $this->body = $body;
        return $this;
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

    /**
     *
     * @return the $image
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     *
     * @param field_type $image            
     */
    public function setImage($image)
    {
        $this->image = $image;
        if ($image) {
            $this->updatedAt = new \DateTime('now');
        }
        return $this;
    }

    /**
     *
     * @return the $image_filename
     */
    public function getImageFilename()
    {
        return $this->imageFileName;
    }

    /**
     *
     * @param field_type $image_filename            
     */
    public function setImageFilename($imageFileName)
    {
        $this->imageFileName = $imageFileName;
        return $this;
    }

    public function getImageWebPath()
    {
        return 'truc';
    }
}


