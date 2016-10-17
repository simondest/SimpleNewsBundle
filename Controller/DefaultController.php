<?php
namespace Vertacoo\SimpleNewsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;


class DefaultController extends Controller
{


    public function updateAction(Request $request, $domain)
    {
        $newsService = $this->container->get('vertacoo_simple_news.news_controller');
        $pathToNewsFile = $newsService->getDomainPath($domain);
        $defaultData = array(
            'news' => $newsService->getNews($domain)
        );
        
        $form = $this->createFormBuilder($defaultData)
            ->add('news', TextareaType::class, array(
            'constraints' => new Length(array(
                'min' => 3
            ))
        ))
            ->add('save', SubmitType::class, array(
            'label' => 'Enregitrer le texte'
        ))
            ->getForm();
        
        $form->handleRequest($request);
        
        if ($form->isValid()) {
            $fs = new Filesystem();
            $data = $form->getData();
            
            $fs->dumpFile($pathToNewsFile, $data['news']);
            
            $this->addFlash('success', 'Changements sauvegardés !');
        }
        return $this->render($this->container->getParameter('vertacoo_simple_news.update_template'), array(
            'form' => $form->createView()
        ));
    }
    
    
   
}
