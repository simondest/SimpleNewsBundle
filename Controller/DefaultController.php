<?php
namespace Vertacoo\SimpleNewsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Filesystem\Filesystem;

class DefaultController extends Controller
{

    public function updateAction(Request $request, $domain)
    {
        $newsService = $this->container->get('vertacoo_simple_news.news_service');
        
        $pathToNewsFile = $newsService->getDomainFile($domain);
        
        $config = $newsService->getDomainConfig($domain);
        
        $news = $newsService->getNews($domain);
        $defaultData = array(
            'news' => $news['text']
        );
        if ($config['use_images'] === true) {
            for ($i = 1; $i <= $config['number']; $i ++) {
                //$defaultData['thumb_image'][$i] = $i . '.jpeg';
            }
        }
        $form = $this->createFormBuilder($defaultData, [
            'translation_domain' => 'VertacooSimpleNewsBundle'
        ])
            ->add('news', TextareaType::class, array(
            'constraints' => new Length(array(
                'min' => 3
            )),
            'label' => 'vertacoo_simple_news.news'
        ))
            ->getForm();
        
        if ($config['use_images'] === true) {
            for ($i = 1; $i <= $config['number']; $i ++) {
                $form->add('image_' . $i, FileType::class, array(
                    'label' => 'Image ' . $i,
                    'required' => false,
                    'image_path' => 'webPath'
                ));
            }
        }
        
        $form->add('save', SubmitType::class, array(
            'label' => 'vertacoo_simple_news.save'
        ));
        $form->handleRequest($request);
        
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
        }
        return $this->render($this->container->getParameter('vertacoo_simple_news.update_template'), array(
            'form' => $form->createView()
        ));
    }
}
