<?php
namespace Vertacoo\SimpleNewsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Vertacoo\SimpleNewsBundle\Entity\News;
use Symfony\Component\Routing\Annotation\Route;
use Vertacoo\SimpleNewsBundle\Doctrine\NewsManager;
use Vertacoo\SimpleNewsBundle\Form\Factory\FormFactory;
use Symfony\Contracts\Translation\TranslatorInterface;

class DefaultController extends AbstractController
{
    /**
     * @Route("/update/{domain}", name="vertacoo_simple_news_admin")
     */
    
    public function update(Request $request, $domain, NewsManager $newsManager, FormFactory $formFactory, TranslatorInterface $translator)
    {
        
        $newsManager->setClass($domain);
        
        $news = $newsManager->findAll();
        if(!$news){
            $news = $newsManager->build();
        }
        else {
            $news = $news[0];
        }
        
        $form = $formFactory->createForm($news);
        
        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $newsManager->persist($news);
                $this->addFlash('success', $translator->trans('vertacoo_simplenews.flash.add'));
                return $this->redirect($request->getUri());
            }
            else {
                $this->addFlash('error', $translator->trans('vertacoo_simplenews.flash.failed'));
            }
        }
        $config = $this->getParameter('vertacoo_simple_news.domains');
        $tpl = $config[$domain]['update_template'];
        return $this->render($tpl, array(
            'form' => $form->createView(),
            'title' => $config[$domain]['title'],
        ));
    }

}