<?php
namespace Vertacoo\SimpleNewsBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
class NewsFormType extends AbstractType {
    protected $class;
    public function __construct($class)
    {
        $this->class = $class;
    }
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('createdAt', DateTimeType::class, array(
            'label' => 'vertacoo_simplenews.label.news.created'
        ))
        ->add('title', TextType::class, array(
            'label' => 'vertacoo_simplenews.label.news.title'
        ))
        ->add('domain', TextType::class, array(
            'label' => 'vertacoo_simplenews.label.news.domain'
        ))
        ->add('body', TextareaType::class, array(
            'label' => 'vertacoo_simplenews.label.news.body'
        ))
        ->add('save',SubmitType::class,array('label' =>'vertacoo_simple_news.label.save'))
        ;
    }
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'vertacoo_simplenews_news';
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class'         => $this->class,
            'intention'          => 'news',
            'translation_domain' => 'VertacooSimpleNewsBundle',
        ));
    }
}

