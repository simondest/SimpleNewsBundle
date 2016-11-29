<?php
namespace Vertacoo\SimpleNewsBundle\Twig;

use Vertacoo\SimpleNewsBundle\Doctrine\NewsManager;

class NewsExtension extends \Twig_Extension
{

    protected $newsManager;

    public function __construct(NewsManager $newsManager)
    {   
        $this->newsManager = $newsManager;
    }

    public function getFunctions()
    {
        return array(
            'file' => new \Twig_SimpleFunction('vertacoo_news', [
                $this,
                'news'
            ])
        );
    }

    public function news($domain, $what)
    {
        $news = $this->newsManager->findOneByDomain($domain);
        if( null=== $news){
            return 'Auncune news pour ce domaine !';
        }
        $field = 'get' . ucfirst($what);
        return $news->$field();
        
        
    }

    public function getName()
    {
        return 'NewsExtension';
    }
}

?>