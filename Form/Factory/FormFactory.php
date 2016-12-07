<?php

/*
 * This file is part of the Mremi\ContactBundle Symfony bundle.
 *
 * (c) Rémi Marseille <marseille.remi@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Vertacoo\SimpleNewsBundle\Form\Factory;

use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Form\FormTypeInterface;

/**
 * Form factory class.
 *
 * @author Rémi Marseille <marseille.remi@gmail.com>
 */
class FormFactory
{

    /**
     *
     * @var FormFactoryInterface
     */
    private $formFactory;

    /**
     *
     * @var array
     */
    private $domainsConfig;

    /**
     *
     * @var \Symfony\Component\HttpFoundation\RequestStack
     */
    private $requestStack;

    private $translator;

    /**
     * Constructor.
     *
     * @param FormFactoryInterface $formFactory
     *            A form factory instance
     * @param string|int $name
     *            The name of the form
     * @param string|\Symfony\Component\Form\FormTypeInterface $type
     *            The type of the form
     * @param array $validationGroups
     *            An array of validation groups
     */
    public function __construct(FormFactoryInterface $formFactory, array $domainsConfig, RequestStack $requestStack, $translator)
    {
        $this->formFactory = $formFactory;
        $this->translator = $translator;
        $this->domainsConfig = $domainsConfig;
        $this->requestStack = $requestStack;
        $this->translator = $translator;
    }

    /**
     * Creates a form and returns it.
     *
     * @param mixed $data
     *            The initial data, optional
     *            
     * @return \Symfony\Component\Form\FormInterface
     */
    public function createForm($data = null)
    {
        $request = $this->requestStack->getCurrentRequest();
        
        $domainConfig = $this->domainsConfig[$request->attributes->get('domain')];
        $type = $domainConfig['form'];
        $entity = $domainConfig['entity'];
        
        return $this->formFactory->create($type, $data, array(
            'domain_config' => $domainConfig,
            'data_class' => $entity
        ));
       
    }
}
