<?php

namespace Phenomena\ActivityBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\DependencyInjection\Definition;
use \Symfony\Component\Config\Definition\Exception\InvalidTypeException;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class PhenomenaActivityExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $config = array();
        foreach ($configs as $subConfig) {
            $config = array_merge($config, $subConfig);
        }

        //@TODO: Add validation
        //$configuration = new Configuration();
        //$config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('listener.xml');
        $loader->load('twig.xml');

        //Load services fore listening
        if (isset($config['activity'])) {
            $this->loadActivities($config,$container);
        }
    }

    private function loadActivities($config,$container) {
        $listener = $container->getDefinition('phenomena_activity.orm.listener');
        foreach ($config['activity'] as $name=>$c) {
            $entity_name = $c['source_entity'];
            $activity_config = array('activity'=>'phenomena_activity.activity.'.$name);
            $listener->addMethodCall('addSourceConfiguration',array($entity_name,$activity_config));
        }
    }
}
