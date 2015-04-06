<?php
namespace Famelo\Sync\Domain\Repository;

use Famelo\Sync\Domain\Model\Pair;
use TYPO3\Flow\Annotations as Flow;
use TYPO3\Flow\Persistence\PersistenceManagerInterface;
use TYPO3\Flow\Persistence\Repository;
use TYPO3\Flow\Reflection\ReflectionService;

/**
 * @Flow\Scope("singleton")
 */
class PairRepository extends Repository {

	/**
	 * @var PersistenceManagerInterface
	 * @Flow\Inject
	 */
	protected $persistenceManager;

	/**
	 * @var ReflectionService
	 * @Flow\Inject
	 */
	protected $reflectionService;


	public function findOrCreate($bond, $item) {
		$itemUuid = $this->persistenceManager->getIdentifierByObject($item);
		$query = $this->createQuery();
		$query->matching($query->logicalAnd(
			$query->equals('localUuid', $itemUuid),
			$query->equals('bond', $bond)
		));

		$pair = $query->execute()->getFirst();
		if (!$pair instanceof Pair) {
			$pair = new Pair();
			$pair->setLocalUuid($itemUuid);
			$pair->setBond($bond);
			$pair->setClassName($this->reflectionService->getClassNameByObject($item));
			$this->persistenceManager->add($pair);
			$this->persistenceManager->whitelistObject($pair);
		}

		return $pair;
	}
}