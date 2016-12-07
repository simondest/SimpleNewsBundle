<?php
namespace Vertacoo\SimpleNewsBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormInterface;

use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Translation\Translator;

class NewsFormType extends AbstractType
{

    protected $class;

    public function __construct($class)
    {
        $this->class = $class;
    }
    

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('createdAt', DateTimeType::class, array(
            'label' => 'vertacoo_simplenews.label.news.created'
        ));
    }
    
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        parent::buildView($view, $form, $options);
    
        $view->vars = array_merge($view->vars, array(
            'domain_config' => $options['domain_config']
        ));
    }

    /**
     *
     * {@inheritdoc}
     *
     */
    public function getName()
    {
        return 'vertacoo_simplenews_news';
    }

    /**
     *
     * {@inheritdoc}
     *
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => $this->class,
            'intention' => 'news',
            'domain_config' => null
        ));
    }
}

