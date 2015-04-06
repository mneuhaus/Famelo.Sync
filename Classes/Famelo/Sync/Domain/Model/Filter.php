<?php
namespace Famelo\Sync\Domain\Model;
use TYPO3\Flow\Annotations as Flow;
use Doctrine\ORM\Mapping as ORM;

/**
 * @Flow\Entity
 */
class Filter {

    /**
    * TODO: Document this Property!
    * @var string
    */
    protected $className;

    /**
    * TODO: Document this Property!
    * @var string
     * @ORM\Column(type="text", nullable=true)
    */
    protected $configuration;

    /**
     * Gets className.
     *
     * @return string $className
     */
    public function getClassName() {
        return $this->className;
    }

    /**
     * Sets the className.
     *
     * @param string $className
     */
    public function setClassName($className) {
        $this->className = $className;
    }

    /**
     * Gets configuration.
     *
     * @return string $configuration
     */
    public function getConfiguration() {
        return $this->configuration;
    }

    /**
     * Sets the configuration.
     *
     * @param string $configuration
     */
    public function setConfiguration($configuration) {
        $this->configuration = $configuration;
    }

}