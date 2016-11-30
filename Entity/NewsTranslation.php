<?php
namespace Vertacoo\SimpleNewsBundle\Entity;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;

class NewsTranslation
{
    use ORMBehaviors\Translatable\Translation;
    protected $title;
    
    protected $body;
    public function getTitle()
    {
        return $this->title;
    }
    
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }
    
    public function getBody()
    {
        return $this->body;
    }
    
    public function setBody($body)
    {
        $this->body = $body;
        return $this;
    }
}

