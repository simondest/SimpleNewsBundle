<?php
namespace Vertacoo\SimpleNewsBundle\Twig;

use Vertacoo\SimpleNewsBundle\Doctrine\NewsManager;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class NewsExtension extends AbstractExtension
{

    protected $newsManager;
    protected $uploader;

    public function __construct(NewsManager $newsManager,  $uploader)
    {   
        $this->newsManager = $newsManager;
        $this->uploader = $uploader;
    }

    public function getFunctions()
    {
        return array(
            'file' => new TwigFunction('vertacoo_news', [
                $this,
                'news'
            ])
        );
    }

    public function news($domain, $what=null, $type='text')
    {

        $this->newsManager->setClass($domain);
        
        $news = $this->newsManager->findOne();
        if( null=== $news){
            return 'Auncune news pour ce domaine !';
        }
        
        if($what == null){
            return $news;
        }

        if($type=='image' && $this->uploader){ 
            $path = $this->uploader->asset($news, $what);
            return $path;
        }
        
        else {
            $getter = 'get' . ucfirst($what);
            if (is_callable([$news, 'translate'])){
                return $news->translate()->$getter();
            }
            else {
                return $news->$getter();
            } 
        }
        
        
        
    }

    public function getName()
    {
        return 'NewsExtension';
    }
}

?>