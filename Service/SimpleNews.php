<?php
namespace Vertacoo\SimpleNewsBundle\Service;

use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;

class SimpleNews
{

    private $path;
    private $twigLoader;
    private $domains;

    public function __construct($path,$twigLoader,$domains)
    {
        $this->path = $path;
        $this->twigLoader = $twigLoader;
        $this->domains = $domains;
    }

    public function getNews($domain)
    {
        if(!$this->domainExists($domain)){
            throw new Exception('Erreur, le domaine "'. $domain  . '" n\'existe pas.'); 
        }
        $news = file_get_contents($this->getDomainPath($domain));
        return $news;
    }

    public function getDomainPath($domain)
    {
        if(!$this->domainExists($domain)){
            throw new Exception('Erreur, le domaine "'. $domain  . '" n\'existe pas.');
        }
        $path = $this->path . $domain . '/news.txt';
        $fs = new Filesystem();
        if (! $fs->exists($this->path . $domain)) {
            $fs->mkdir($this->path . $domain);
            $fs->touch($path);
        }
        
        return $path;
    }
    private function domainExists($domain){
        if(in_array($domain, $this->domains)){
            return true;
        }
        return false;
    }
}

?>