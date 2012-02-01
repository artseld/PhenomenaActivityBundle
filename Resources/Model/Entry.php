<?php

namespace Phenomena\ActivityBundle\Model;

/**
 * Phenomena\ActivityBundle\Entity\Entry
 */
abstract class Entry
{

    /**
     * @var text $params
     */
    protected $params;

    /**
     * @var datetime $created_at
     */
    protected $created_at;

    /**
     * @var string $template
     */
    protected $template;

    public function __construct() {
        $this->created_at = new \DateTime('now');
    }

    /**
     * Set template params
     *
     * @param array $params
     */
    public function setParams(array $params)
    {
        $this->params = serialize($params);
    }

    /**
     * Get template params
     *
     * @return array
     */
    public function getParams()
    {
        return (array)unserialize($this->params);
    }

    /**
     * Set created_at
     *
     * @param datetime $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        $this->created_at = $createdAt;
    }

    /**
     * Get created_at
     *
     * @return datetime 
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * Set template name
     *
     * @param string $template
     */
    public function setTemplate($template)
    {
        $this->template = $template;
    }

    /**
     * Get template name
     *
     * @return string
     */
    public function getTemplate()
    {
        return $this->template;
    }
}