<?php
namespace Famelo\Sync\ViewHelpers;
/*                                                                        *
 * This script belongs to the TYPO3 Flow package &quot;Famelo.Sync&quot;.           *
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use TYPO3\Flow\Persistence\PersistenceManagerInterface;

class UuidViewHelper extends \TYPO3\Fluid\Core\ViewHelper\AbstractViewHelper {
	/**
	 * @var PersistenceManagerInterface
	 * @Flow\Inject
	 */
	protected $persistenceManager;

	/**
	 *
	 * @param object $object
	 * @return string
	 */
	public function render($object) {
		return $this->persistenceManager->getIdentifierByObject($object);
	}
}