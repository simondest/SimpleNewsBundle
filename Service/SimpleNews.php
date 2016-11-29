<?php
namespace Vertacoo\SimpleNewsBundle\Service;

use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;

class SimpleNews
{

    private $path;

    private $domains;

    public function __construct($path, $domains)
    {
        $this->path = $path;
        $this->domains = $domains;
    }

    public function getNews($domain)
    {
        if (! $this->domainExists($domain)) {
            throw new Exception('Erreur, le domaine "' . $domain . '" n\'existe pas.');
        }
        $news = array();
        $news['text'] = file_get_contents($this->getDomainFile($domain));
        return $news;
    }

    public function getImage($domain, $image)
    {
        if (! $this->domainExists($domain)) {
            throw new Exception('Erreur, le domaine "' . $domain . '" n\'existe pas.');
        }
        return $this->path . $image;
    }

    public function getDomainFile($domain)
    {
        if (! $this->domainExists($domain)) {
            throw new Exception('Erreur, le domaine "' . $domain . '" n\'existe pas.');
        }
        $path = $this->path . $domain . '/news.txt';
        $fs = new Filesystem();
        if (! $fs->exists($this->path . $domain)) {
            $fs->mkdir($this->path . $domain);
            $fs->touch($path);
        }
        
        return $path;
    }

    public function getDomainDirectory($domain)
    {
        if (! $this->domainExists($domain)) {
            throw new Exception('Erreur, le domaine "' . $domain . '" n\'existe pas.');
        }
        $path = $this->path . $domain;
        
        return $path;
    }

    public function getDomainConfig($domain)
    {
        if (! $this->domainExists($domain)) {
            throw new Exception('Erreur, le domaine "' . $domain . '" n\'existe pas.');
        }
        return $this->domains[$domain];
    }

    private function domainExists($domain)
    {
        if (array_key_exists($domain, $this->domains)) {
            return true;
        }
        return false;
    }
}

?>