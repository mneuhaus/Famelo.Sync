<?php
namespace Famelo\Sync\Controller;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "Famelo.Sync".           *
 *                                                                        *
 *                                                                        */

use Famelo\Sync\Domain\Model\Bond;
use Famelo\Sync\Domain\Model\Filter;
use Famelo\Sync\Domain\Repository\BondRepository;
use Famelo\Sync\Domain\Repository\FilterRepository;
use Famelo\Sync\Domain\Repository\PairRepository;
use TYPO3\Flow\Annotations as Flow;
use TYPO3\Flow\Reflection\ReflectionService;
use TYPO3\Flow\Utility\Algorithms;

class SyncController extends \TYPO3\Flow\Mvc\Controller\ActionController {

	/**
	 * @var BondRepository
	 * @Flow\Inject
	 */
	protected $bondRepository;

	/**
	 * @var PairRepository
	 * @Flow\Inject
	 */
	protected $pairRepository;

	/**
	 * @var ReflectionService
	 * @Flow\Inject
	 */
	protected $reflectionService;

	/**
	 * @return void
	 */
	public function indexAction() {
		$classNames = $this->reflectionService->getClassNamesByAnnotation('\TYPO3\Flow\Annotations\Entity');
		$this->view->assign('classNames', $classNames);
	}

	/**
	 * @param string $className
	 * @return void
	 */
	public function listAction($className) {
		$pairs = array();
		$localItems = $this->persistenceManager->createQueryForType($className)->execute();
		$bonds = $this->bondRepository->findAll();
		$rows = array();
		foreach ($localItems as $localItem) {
			$row = array(
				'item' => $localItem,
				'pairs' => array()
			);
			foreach ($bonds as $bond) {
				$row['pairs'][] = $this->pairRepository->findOrCreate($bond, $localItem);
			}
			$rows[] = $row;
		}
		$this->view->assign('rows', $rows);
	}

	/**
	 * @return void
	 */
	public function contextAction() {
		return $this->objectManager->getContext();
	}

	/**
	 * @param string $className
	 * @return void
	 */
	public function getListAction($className) {
		$this->view->assign('items', $this->persistenceManager->createQueryForType($className)->execute());
	}

}