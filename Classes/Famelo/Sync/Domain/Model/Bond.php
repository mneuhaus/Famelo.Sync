<?php
namespace Famelo\Sync\Domain\Model;
use TYPO3\Flow\Annotations as Flow;
use Doctrine\ORM\Mapping as ORM;

/**
 * @Flow\Entity
 */
class Bond {

    /**
    * TODO: Document this Property!
    * @var string
    */
    protected $uri;

    /**
    * TODO: Document this Property!
    * @var string
     * @ORM\Column(nullable=true)
    */
    protected $token;

    public function __toString() {
        return $this->uri;
    }

    /**
     * Gets token.
     *
     * @return string $token
     */
    public function getToken() {
        return $this->token;
    }

    /**
     * Sets the token.
     *
     * @param string $token
     */
    public function setToken($token) {
        $this->token = $token;
    }

    /**
     * Gets uri.
     *
     * @return string $uri
     */
    public function getUri() {
        return $this->uri;
    }

    /**
     * Sets the uri.
     *
     * @param string $uri
     */
    public function setUri($uri) {
        $this->uri = $uri;
    }

}