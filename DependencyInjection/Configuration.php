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

    /**
     * @ERROR!!!
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('vertacoo_simple_news');
        $rootNode->children()
                        ->scalarNode('entity')->defaultValue('Vertacoo\SimpleNewsBundle\Entity\News')->end()
                        ->arrayNode('domains')
                            ->prototype('array')
                                ->children()
                                    ->scalarNode('form')->defaultValue("Vertacoo\SimpleNewsBundle\Form\Type\NewsFormType")->end()
                                    ->scalarNode('title')->defaultValue('News')->end()
                                    ->booleanNode('use_image')->defaultFalse()->end()
                                    ->scalarNode('image_max_size')->defaultValue("1MO")->end()
                                    ->integerNode('image_max_height')->defaultValue(600)->end()
                                    ->integerNode('image_max_width')->defaultValue(800)->end()
                                ->end()
                            ->end()
                            ->defaultValue(array(
                                'Default'
                            ))
                        ->end()
                        ->scalarNode('update_template')->defaultValue('VertacooSimpleNewsBundle:Default:update.html.twig')->cannotBeEmpty()->end()
                    ->end();
        
        
        return $treeBuilder;
    }
}
