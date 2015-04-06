<?php
namespace Famelo\Sync\Controller;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "Famelo.Sync".           *
 *                                                                        *
 *                                                                        */

use Famelo\Sync\Domain\Model\Filter;
use Famelo\Sync\Domain\Repository\FilterRepository;
use TYPO3\Flow\Annotations as Flow;
use TYPO3\Flow\Reflection\ReflectionService;

class FilterController extends \TYPO3\Flow\Mvc\Controller\ActionController {

	/**
	 * @var FilterRepository
	 * @Flow\Inject
	 */
	protected $filterRepository;

	/**
	 * @var ReflectionService
	 * @Flow\Inject
	 */
	protected $reflectionService;


	/**
	 * @return void
	 */
	public function indexAction() {
		$filters = $this->filterRepository->findAll();
		$this->view->assign('filters', $filters);
		$classNames = $this->reflectionService->getClassNamesByAnnotation('\TYPO3\Flow\Annotations\Entity');
		foreach ($filters as $filter) {
			$index = array_search($filter->getClassName(), $classNames);
			unset($classNames[$index]);
		}
		sort($classNames);
		$this->view->assign('classNames', $classNames);
	}

	/**
	 * @param string $className
	 * @return void
	 */
	public function addAction($className) {
		$filter = new Filter();
		$filter->setClassName($className);
		$this->filterRepository->add($filter);
		$this->persistenceManager->persistAll();
		$this->redirect('edit', NULL, NULL, array('filter' => $filter));
	}

	/**
	 * @param Filter $filter
	 * @return void
	 */
	public function editAction($filter) {
		$this->view->assign('filter', $filter);
		$configuration = unserialize($filter->getConfiguration());

		$properties = array();
		foreach ($this->reflectionService->getClassPropertyNames($filter->getClassName()) as $propertyName) {
			if ($propertyName === 'Persistence_Object_Identifier') {
				continue;
			}
			$exclude = FALSE;
			if (isset($configuration[$propertyName])) {
				if ($configuration[$propertyName]['exclude'] == 1) {
					$exclude = TRUE;
				}
			}
			$properties[$propertyName] = array(
				'name' => $propertyName,
				'type' => $this->getPropertyType($filter->getClassName(), $propertyName),
				'exclude' => $exclude
			);
		}
		ksort($properties);
		$this->view->assign('properties', $properties);
	}

	/**
	 * @param Filter $filter
	 * @param array $properties
	 * @return void
	 */
	public function saveAction($filter, $properties = array()) {
		$filter->setConfiguration(serialize($properties));
		$this->filterRepository->update($filter);
		$this->redirect('index');
	}

	public function getPropertyType($className, $propertyName) {
		$vars = $this->reflectionService->getPropertyTagValues($className, $propertyName, 'var');

		return $vars[0];
	}

}