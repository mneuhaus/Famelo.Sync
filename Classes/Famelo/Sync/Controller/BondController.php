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
use TYPO3\Flow\Annotations as Flow;
use TYPO3\Flow\Reflection\ReflectionService;
use TYPO3\Flow\Utility\Algorithms;

class BondController extends \TYPO3\Flow\Mvc\Controller\ActionController {

	/**
	 * @var BondRepository
	 * @Flow\Inject
	 */
	protected $bondRepository;

	/**
	 * @var ReflectionService
	 * @Flow\Inject
	 */
	protected $reflectionService;


	/**
	 * @return void
	 */
	public function indexAction() {
		$this->view->assign('bonds', $this->bondRepository->findAll());
	}

	/**
	 * @param string $uri
	 * @return void
	 */
	public function startBondingAction($uri) {
		$bond = new Bond();
		$bond->setUri($uri);
		$this->bondRepository->add($bond);
		$this->persistenceManager->persistAll();

		$this->uriBuilder->reset();
		$returnUri = $this->uriBuilder->setCreateAbsoluteUri(TRUE)->uriFor('receiveToken', array(
			'bond' => $bond
		));

		$this->uriBuilder->reset();
		$uri = rtrim($uri, '/') . $this->uriBuilder->setCreateAbsoluteUri(FALSE)->uriFor('authorize', array(
			'returnUri' => $returnUri
		));
		$this->redirectToUri($uri);
	}

	/**
	 * @param string $returnUri
	 * @return void
	 */
	public function authorizeAction($returnUri) {

		// todo: check for a logged in user with administrator role

		$tokenFile = FLOW_PATH_DATA . 'bonding_security_token';
		if (!file_exists($tokenFile)) {
			$token = Algorithms::generateRandomString(256, 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789');
			file_put_contents($tokenFile, $token);
		}
		$this->view->assign('token', file_get_contents($tokenFile));
		$this->view->assign('returnUri', $returnUri);
	}

	/**
	 * @param Bond $bond
	 * @param string $token
	 * @return void
	 */
	public function receiveTokenAction($bond, $token) {
		$bond->setToken($token);
		$this->bondRepository->update($bond);
		$this->persistenceManager->persistAll();
		$this->redirect('index');
	}

	// /**
	//  * @param Bond $bond
	//  * @return void
	//  */
	// public function fetchContextAction($bond) {
	// 	$this->uriBuilder->reset();
	// 	$uri = rtrim($bond->getUri(), '/') . $this->uriBuilder->setCreateAbsoluteUri(FALSE)->uriFor('getContext', array(), 'Sync');
	// 	$request = \Requests::get($uri);

	// 	var_dump($request);
	// 	return $uri;

	// 	var_dump($request->body);
	// }

}