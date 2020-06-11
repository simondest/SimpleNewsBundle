<?php
namespace Vertacoo\SimpleNewsBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files.
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/configuration.html}
 */
class Configuration implements ConfigurationInterface
{

    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder('vertacoo_simple_news');
        $rootNode = $treeBuilder->getRootNode($treeBuilder,'vertacoo_simple_news');
        $rootNode->children()
                        ->scalarNode('entity')->defaultValue('Vertacoo\SimpleNewsBundle\Entity\News')->end()
                        ->arrayNode('domains')
                            ->prototype('array')
                                ->children()
                                    ->scalarNode('form')->defaultValue("Vertacoo\SimpleNewsBundle\Form\Type\NewsFormType")->end()
                                    ->scalarNode('entity')->cannotBeEmpty()->end()
                                    ->scalarNode('title')->defaultValue('News')->end()
                                    ->scalarNode('update_template')->defaultValue('VertacooSimpleNewsBundle:Default:update.html.twig')->end()
                                ->end()
                            ->end()
                            ->defaultValue(array(
                                'Default'
                            ))
                        ->end()
                    ->end();
        
        
        return $treeBuilder;
    }
}
