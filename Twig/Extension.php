<?php
/**
 * @author shutin
 */
namespace Phenomena\ActivityBundle\Twig;

use Symfony\Component\DependencyInjection\Container;
use Phenomena\ActivityBundle\Model\Entry;

class Extension extends \Twig_Extension {

    /**
     * @var \Symfony\Component\DependencyInjection\Container
     */
    private $container;

    public function __construct(Container $container) {
        $this->container = $container;
    }

    public function getFunctions() {
        return array('render_activity_entry'=>new \Twig_Function_Method($this,'renderEntry',array('is_safe'=>array('html'))));
    }

    public function renderEntry(Entry $entry) {
        $templating = $this->container->get('templating');

        if (!$templating->supports($entry->getTemplate())) {
            throw new \InvalidArgumentException(sprintf('Templating "%s" doesn\'t support template "%s',get_class($templating),$entry->getTemplate()));
        }

        return $templating->render($entry->getTemplate(),$entry->getParams());
    }

    public function getName() {
        return 'phenomena_activity_twig_extension';
    }

}
