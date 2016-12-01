<?php
namespace Vertacoo\SimpleNewsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Vertacoo\SimpleNewsBundle\Entity\News;

class DefaultController extends Controller
{

    public function updateAction(Request $request, $domain)
    {
        
        $manager = $this->getNewsManager();
        $news = $manager->findOneByDomain($domain);
        if(!$news){
            $news = $manager->build(null,null,$domain);
        }
        $domainConfig = $this->getParameter('vertacoo_simple_news.domains')[$domain];

        $form = $this->createForm($domainConfig['form'], $news,array('domain_config'=>$domainConfig));
        
        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);
            $translator = $this->get('translator');
            if ($form->isValid()) {
                $manager->persist($news);
                $this->addFlash('success', $translator->trans('vertacoo_simplenews.flash.add'));
                return $this->redirect($request->getUri());
            }
            else {
                $this->addFlash('error', $translator->trans('vertacoo_simplenews.flash.failed'));
            }
        }
       
        return $this->render($this->container->getParameter('vertacoo_simple_news.update_template'), array(
            'form' => $form->createView()
        ));
    }
    
    private function getNewsManager() {
        return $this->get('vertacoo_simple_news.news_manager');
    }
}
