<?php


namespace Phenomena\ActivityBundle\Listener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Symfony\Component\DependencyInjection\Container;

class EntityListener {

    private $source_configuration = array();

    /**
     * @var \Symfony\Component\DependencyInjection\Container
     */
    private $container;

    public function __construct(Container $container) {
        $this->container = $container;
    }

    public function handleEvent(LifecycleEventArgs $args) {

        /**
         * the same can be done via instanceof but it will be 50+ times slower
         */
        $class = get_class($args->getEntity());
        if (mb_strpos($class,'Proxies\\') === 0) { //This is proxy class.
            $class = mb_substr($class,14);
        }

        $class = str_replace('\\','',$class);

        if (isset($this->source_configuration[$class])) {
            foreach ($this->source_configuration[$class] as $configuration) {
                $activity = $this->container->get($configuration['activity']);
                $activity->init($args);
                $activity->save();
            }
        }
    }

    public function postPersist(LifecycleEventArgs $args) {
        return $this->handleEvent($args);
    }

    public function postUpdate(LifecycleEventArgs $args) {
        return $this->handleEvent($args);
    }

    public function postRemove(LifecycleEventArgs $args) {
        return $this->handleEvent($args);
    }


    public function addSourceConfiguration($entity_name, $config) {
        $entity_name = str_replace('\\','',$entity_name);

        if (!isset($this->source_configuration[$entity_name])) {
            $this->source_configuration[$entity_name] = array();
        }
        $this->source_configuration[$entity_name][]=$config;
    }
}