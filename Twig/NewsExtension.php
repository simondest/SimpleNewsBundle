<?php
namespace Vertacoo\SimpleNewsBundle\Twig;

use Vertacoo\SimpleNewsBundle\Doctrine\NewsManager;
use Vich\UploaderBundle\Templating\Helper\UploaderHelper;

class NewsExtension extends \Twig_Extension
{

    protected $newsManager;
    protected $uploader;

    public function __construct(NewsManager $newsManager, UploaderHelper $uploader)
    {   
        $this->newsManager = $newsManager;
        $this->uploader = $uploader;
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

        if($what=='image' && $this->uploader){
            
;            $path = $this->uploader->asset($news, 'image');
            return $path;
        }
        else {
            $getter = 'get' . ucfirst($what);
            return $news->translate()->$getter();
        }
        
        
        
    }

    public function getName()
    {
        return 'NewsExtension';
    }
}

?>