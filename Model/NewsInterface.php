<?php
namespace Vertacoo\SimpleNewsBundle\Model;

interface NewsInterface
{
    public function getCreatedAt();

    public function setCreatedAt(\DateTime $created_at);

    public function getUpdatedAt();

    public function setUpdatedAt(\DateTime $updated_at);
    
    public function getDomain();
    
    public function setDomain($domain);
}