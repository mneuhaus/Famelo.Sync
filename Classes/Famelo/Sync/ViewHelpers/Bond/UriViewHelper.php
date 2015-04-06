<?php
namespace Famelo\Sync\ViewHelpers\Bond;
/*                                                                        *
 * This script belongs to the TYPO3 Flow package &quot;Famelo.Sync&quot;.           *
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use TYPO3\Fluid\ViewHelpers\Uri\ActionViewHelper;

class UriViewHelper extends ActionViewHelper {

	/**
	 * Render the Uri.
	 *
	 * @param string $action Target action
	 * @param array $arguments Arguments
	 * @param string $controller Target controller. If NULL current controllerName is used
	 * @param string $package Target package. if NULL current package is used
	 * @param string $subpackage Target subpackage. if NULL current subpackage is used
	 * @param string $section The anchor to be added to the URI
	 * @param string $format The requested format, e.g. ".html"
	 * @param array $additionalParams additional query parameters that won't be prefixed like $arguments (overrule $arguments)
	 * @param boolean $absolute If set, an absolute URI is rendered
	 * @param boolean $addQueryString If set, the current query parameters will be kept in the URI
	 * @param array $argumentsToBeExcludedFromQueryString arguments to be removed from the URI. Only active if $addQueryString = TRUE
	 * @param boolean $useParentRequest If set, the parent Request will be used instead of the current one
	 * @param object $bond
	 * @return string The rendered link
	 * @throws ViewHelper\Exception
	 * @api
	 */
	public function render($action, array $arguments = array(), $controller = NULL, $package = NULL, $subpackage = NULL, $section = '', $format = '', array $additionalParams = array(), $absolute = FALSE, $addQueryString = FALSE, array $argumentsToBeExcludedFromQueryString = array(), $useParentRequest = FALSE, $bond = NULL) {
		$uri = parent::render($action, $arguments, $controller, $package, $subpackage, $section, $format, $additionalParams, $absolute, $addQueryString, $argumentsToBeExcludedFromQueryString, $useParentRequest);
		return rtrim($bond->getUri(), '/') . $uri;
	}

}