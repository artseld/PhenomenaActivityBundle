<?php
/**
 * @author shutin
 */
namespace Phenomena\ActivityBundle\Activity;

use Doctrine\ORM\Event\LifecycleEventArgs;

use OldSound\RabbitMqBundle\RabbitMq\ConsumerInterface;
use OldSound\RabbitMqBundle\RabbitMq\Producer;
use \Symfony\Component\Templating\EngineInterface;
use Symfony\Bundle\DoctrineBundle\Registry;

abstract class AbstractActivity implements ConsumerInterface
{
    /**
     * @var string
     */
    private $template;

    /**
     * @var string
     */
    private $name;

    /**
     * @var \OldSound\RabbitMqBundle\RabbitMq\Producer
     */
    private $producer;

    /*
     * @var \Doctrine\ORM\EntityManager
     */
    private $em;

    /**
     * @var \Symfony\Component\Templating\EngineInterface
     */
    private $templating;

    public function __construct($name,Producer $producer, $template = null) {
        $this->name = $name;
        $this->producer = $producer;
        $this->template = ($template) ? $template : 'PhenomenaActivityBundle:Activity:'.$name.'.html.twig';
    }

    abstract public function init(LifecycleEventArgs $event);

    final public function save() {
        $msg = serialize($this->export());
        if ($msg) {
            $this->getProducer()->publish($msg,$this->getName());
        }
    }

    abstract protected function export();

    abstract protected function process();

    abstract protected function import($source);

    final public function execute($msg) {
        if ($this->import($msg)) {
            $this->process($msg);
        }
    }

    public function getTemplate() {
        return $this->template;
    }

    public function getName() {
        return $this->name;
    }

    public function getProducer() {
        return $this->producer;
    }
}

