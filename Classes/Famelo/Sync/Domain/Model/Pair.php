<?php
namespace Famelo\Sync\Domain\Model;
use Doctrine\ORM\Mapping as ORM;
use TYPO3\Flow\Annotations as Flow;
use TYPO3\Flow\Persistence\PersistenceManagerInterface;

/**
 * @Flow\Entity
 */
class Pair {

    /**
    * TODO: Document this Property!
    * @var string
    */
    protected $localUuid;

    /**
     * @var string
     */
    protected $className;

    /**
    * TODO: Document this Property!
    * @var string
     * @ORM\Column(nullable=true)
    */
    protected $remoteUuid;

    /**
     * @var \Famelo\Sync\Domain\Model\Bond
     * @ORM\ManyToOne
     */
    protected $bond;

    /**
     * @var PersistenceManagerInterface
     * @Flow\Inject
     * @Flow\Transient
     */
    protected $persistenceManager;

    /**
     * Gets name.
     *
     * @return string $name
     */
    public function getName() {
        return $this->name;
    }

    /**
     * Sets the name.
     *
     * @param string $name
     */
    public function setName($name) {
        $this->name = $name;
    }

    /**
     * Gets localUuid.
     *
     * @return string $localUuid
     */
    public function getLocalUuid() {
        return $this->localUuid;
    }

    /**
     * Sets the localUuid.
     *
     * @param string $localUuid
     */
    public function setLocalUuid($localUuid) {
        $this->localUuid = $localUuid;
    }

    /**
     * Gets remoteUuid.
     *
     * @return string $remoteUuid
     */
    public function getRemoteUuid() {
        return $this->remoteUuid;
    }

    /**
     * Sets the remoteUuid.
     *
     * @param string $remoteUuid
     */
    public function setRemoteUuid($remoteUuid) {
        $this->remoteUuid = $remoteUuid;
    }

    /**
     * @param \Famelo\Sync\Domain\Model\Bond $bond
     */
    public function setBond($bond) {
        $this->bond = $bond;
    }

    /**
     * @return \Famelo\Sync\Domain\Model\Bond
     */
    public function getBond() {
        return $this->bond;
    }

    /**
     * @param string $className
     */
    public function setClassName($className) {
        $this->className = $className;
    }

    /**
     * @return string
     */
    public function getClassName() {
        return $this->className;
    }

    public function getLocalObject() {
        return $this->persistenceManager->getObjectByIdentifier($this->localUuid, $this->className);
    }

}