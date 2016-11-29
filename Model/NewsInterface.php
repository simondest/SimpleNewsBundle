<?php
namespace Vertacoo\SimpleNewsBundle\Model;

interface NewsInterface
{
    public function getTitle();

    public function setTitle($title);

    public function getBody();

    public function setBody($body);

    public function getCreatedAt();

    public function setCreatedAt(\DateTime $created_at);

    public function getUpdatedAt();

    public function setUpdatedAt(\DateTime $updated_at);
    
    public function getDomain();
    
    public function setDomain($domain);
}

