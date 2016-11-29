<?php
namespace Vertacoo\SimpleNewsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Filesystem\Filesystem;
use Vertacoo\SimpleNewsBundle\Form\Type\NewsFormType;
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
        $form = $this->createForm(NewsFormType::class, $news);
        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $manager->persist($news);
                $this->addFlash('success', 'vertacoo_simplenews.flash.add');
            }
        }
       /* return array('form' => $form->createView());
        if ($form->isValid()) {
            $fs = new Filesystem();
            if ($config['use_images'] === true) {
                $data = $form->getData();
                for ($i = 1; $i <= $config['number']; $i ++) {
                    if (isset($data['image_' . $i])) {
                        $file = $data['image_' . $i];
                        $fileName = $i . '.' . $file->guessExtension();
                        $file->move($newsService->getDomainDirectory($domain), $fileName);
                    } else {
                        continue;
                    }
                }
            }
            
            $fs->dumpFile($pathToNewsFile, $data['news']);
            
            $this->addFlash('success', 'Changements sauvegardés !');
        }*/
        return $this->render($this->container->getParameter('vertacoo_simple_news.update_template'), array(
            'form' => $form->createView()
        ));
    }
    
    private function getNewsManager() {
        return $this->get('vertacoo_simple_news.news_manager');
    }
}
