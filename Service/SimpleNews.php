<?php
namespace Vertacoo\SimpleNewsBundle\Service;

use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;

class SimpleNews
{

    private $path;

    public function __construct($path)
    {
        $this->path = $path;
    }

    public function getNews($domain)
    {
        $news = file_get_contents($this->getDomainPath($domain));
        return $news;
    }

    public function getDomainPath($domain)
    {
        $path = $this->path . $domain . '/news.txt';
        $fs = new Filesystem();
        if (! $fs->exists($this->path . $domain)) {
            $fs->mkdir($this->path . $domain);
            $fs->touch($path);
        }
        
        return $path;
    }
}

?>