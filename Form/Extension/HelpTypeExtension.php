<?php
namespace Vertacoo\SimpleNewsBundle\Form\Extension;

use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;

class HelpTypeExtension extends AbstractTypeExtension
{
    public function getExtendedType()
    {
        return 'Symfony\Component\Form\Extension\Core\Type\FormType';
    }

    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars = array_merge($view->vars, array('help' => $options['help']));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array('help' => null));
    }
}

