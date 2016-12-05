<?php
namespace Vertacoo\SimpleNewsBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Symfony\Component\Validator\Constraints\Image;
use Symfony\Component\Translation\Translator;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class NewsFormType extends AbstractType
{

    protected $class;

    protected $translator;

    public function __construct($class, Translator $translator)
    {
        $this->class = $class;
        $this->translator = $translator;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('createdAt', DateTimeType::class, array(
            'label' => 'vertacoo_simplenews.label.news.created'
        ))
            ->add('title', TextType::class, array(
            'label' => 'vertacoo_simplenews.label.news.title',
            'constraints' => array(
                new NotBlank()
            )
        ))
       /*     ->add('domain', TextType::class, array(
            'label' => 'vertacoo_simplenews.label.news.domain'
        ))*/
            ->add('body', TextareaType::class, array(
            'label' => 'vertacoo_simplenews.label.news.body',
            'constraints' => array(
                new NotBlank(),
                new Length(array(
                    'min' => 5
                ))
            )
        ));
        if ($options['domain_config']['use_image'] == true) {
            $helpMessage = $this->translator->trans('vertacoo_simplenews.help.news.image', array(
                '%maxSize%' => $options['domain_config']["image_max_size"],
                '%maxWidth%' => $options['domain_config']["image_max_width"],
                '%maxHeight%' => $options['domain_config']["image_max_height"]
            ));
            $builder->add('image', VichImageType::class, array(
                'required' => false,
                'constraints' => array(
                    new Image(array(
                        'maxSize' => $options['domain_config']["image_max_size"],
                        'maxHeight' => $options['domain_config']["image_max_height"],
                        'maxWidth' => $options['domain_config']["image_max_width"]
                    ))
                ),
                'help' => $helpMessage
            ));
        }
        $builder->add('translations', 'A2lix\TranslationFormBundle\Form\Type\TranslationsType', array(
            'label' => 'vertacoo_simplenews.label.news.translation',
            // 'locales' => array('en'),
            'required' => false,
            'fields' => array(
                'title' => array(
                    'constraints' => array(
                        new Length(array(
                            'min' => 5
                        ))
                    )
                ),
                'body' => array(
                    'constraints' => array(
                        new Length(array(
                            'min' => 5
                        ))
                    )
                )
            )
            
        ));
        $builder->add('save', SubmitType::class, array(
            'label' => 'vertacoo_simple_news.label.save'
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

