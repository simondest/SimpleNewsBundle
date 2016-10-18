<?php
namespace Vertacoo\SimpleNewsBundle\Twig;

use Vertacoo\SimpleNewsBundle\Service\SimpleNews;

class NewsExtension extends \Twig_Extension
{

    protected $newsService;

    public function __construct(SimpleNews $newsService)
    {
        $this->newsService = $newsService;
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

    
    public function news($domain)
    {
        return $this->newsService->getNews($domain);
    }

    public function getName()
    {
        return 'NewsExtension';
    }
}

?>