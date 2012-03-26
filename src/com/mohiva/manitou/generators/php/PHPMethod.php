<?php
/**
 * Mohiva Manitou
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.textile.
 * It is also available through the world-wide-web at this URL:
 * https://github.com/mohiva/manitou/blob/master/LICENSE.textile
 *
 * @category  Mohiva/Manitou
 * @package   Mohiva/Manitou/Exceptions
 * @author    Christian Kaps <christian.kaps@mohiva.com>
 * @copyright Copyright (c) 2007-2012 Christian Kaps (http://www.mohiva.com)
 * @license   https://github.com/mohiva/manitou/blob/master/LICENSE.textile New BSD License
 * @link      https://github.com/mohiva/manitou
 */
namespace com\mohiva\manitou\generators\php;

use com\mohiva\manitou\exceptions\UnexpectedScopeException;
use com\mohiva\manitou\exceptions\FinalAbstractClassMethodException;
use com\mohiva\manitou\exceptions\StaticAbstractClassMethodException;
use com\mohiva\manitou\exceptions\AbstractClassMethodContainsBodyException;
use com\mohiva\manitou\exceptions\AbstractInterfaceMethodException;
use com\mohiva\manitou\exceptions\FinalInterfaceMethodException;
use com\mohiva\manitou\exceptions\InterfaceMethodContainsBodyException;

/**
 * Generates the source code for a method.
 *
 * @category  Mohiva/Manitou
 * @package   Mohiva/Manitou/Exceptions
 * @author    Christian Kaps <christian.kaps@mohiva.com>
 * @copyright Copyright (c) 2007-2012 Christian Kaps (http://www.mohiva.com)
 * @license   https://github.com/mohiva/manitou/blob/master/LICENSE.textile New BSD License
 * @link      https://github.com/mohiva/manitou
 */
class PHPMethod extends PHPMember {

	/**
	 * Method scopes.
	 *
	 * @var int
	 */
	const SCOPE_CLASS     = 1;
	const SCOPE_INTERFACE = 2;

	/**
	 * A list with parameters for this method.
	 *
	 * @var array
	 */
	protected $parameters = array();

	/**
	 * Indicates if the method is abstract or not.
	 *
	 * @var boolean
	 */
	protected $isAbstract = false;

	/**
	 * Indicates if the method is final or not.
	 *
	 * @var boolean
	 */
	protected $isFinal = false;

	/**
	 * The scope of the method. This must be one of the values
	 * from the `SCOPE_*` constants defined in this
	 * class.
	 *
	 * @var int
	 */
	protected $scope = self::SCOPE_CLASS;

	/**
	 * The body of the method.
	 *
	 * @var PHPRawCode
	 */
	protected $body = null;

	/**
	 * The class constructor.
	 *
	 * @param string $name The name of the method.
	 * @param int $visibility The value of on of the predefined `VISIBILITY_*` constants.
	 * @param int $scope The value of on of the predefined `SCOPE_*` constants.
	 * @param boolean $isAbstract True if the method is abstract, false otherwise.
	 * @param boolean $isFinal True if the method is final, false otherwise.
	 * @param boolean $isStatic True if the method is static, false otherwise.
	 */
	public function __construct(
		$name,
		$visibility = self::VISIBILITY_PUBLIC,
		$scope = self::SCOPE_CLASS,
		$isAbstract = false,
		$isFinal = false,
		$isStatic = false) {

		$this->name = $name;
		$this->visibility = $visibility;
		$this->scope = $scope;
		$this->isAbstract = $isAbstract;
		$this->isFinal = $isFinal;
		$this->isStatic = $isStatic;
	}

	/**
	 * Sets a list with `PHPParameter` objects.
	 *
	 * @param array $parameters A list with `PHPParameter` objects.
	 * @return PHPMember This object instance to provide a fluent interface.
	 */
	public function setParameters(array $parameters) {

		$this->parameters = array();
		foreach ($parameters as $parameter) {
			$this->addParameter($parameter);
		}

		return $this;
	}

	/**
	 * Gets the list with all defined `PHPParameter` objects.
	 *
	 * @return array A list with `PHPParameter` objects.
	 */
	public function getParameters() {

		return $this->parameters;
	}

	/**
	 * Add a new parameter to the `$parameters` list.
	 *
	 * @param PHPParameter $parameter The parameter to add.
	 * @return PHPMethod This object instance to provide a fluent interface.
	 */
	public function addParameter(PHPParameter $parameter) {

		$this->parameters[spl_object_hash($parameter)] = $parameter;

		return $this;
	}

	/**
	 * Remove an parameter from the `$parameters` list.
	 *
	 * @param PHPParameter $parameter The parameter to remove.
	 * @return PHPMember This object instance to provide a fluent interface.
	 */
	public function removeParameter(PHPParameter $parameter) {

		$id = spl_object_hash($parameter);
		if (isset($this->parameters[$id])) {
			unset($this->parameters[$id]);
		}

		return $this;
	}

	/**
	 * Defines if the method is abstract or not.
	 *
	 * @param boolean $isAbstract True if the method is abstract, false otherwise.
	 * @return PHPMethod This object instance to provide a fluent interface.
	 */
	public function setAbstract($isAbstract) {

		$this->isAbstract = $isAbstract;

		return $this;
	}

	/**
	 * Indicates if the method is abstract or not.
	 *
	 * @return boolean True if the method is abstract, false otherwise.
	 */
	public function isAbstract() {

		return $this->isAbstract;
	}

	/**
	 * Defines if the method is final or not.
	 *
	 * @param boolean $isFinal True if the method is final, false otherwise.
	 * @return PHPMethod This object instance to provide a fluent interface.
	 */
	public function setFinal($isFinal) {

		$this->isFinal = $isFinal;

		return $this;
	}

	/**
	 * Indicates if the method is final or not.
	 *
	 * @return boolean True if the method is final, false otherwise.
	 */
	public function isFinal() {

		return $this->isFinal;
	}

	/**
	 * Sets the scope of the method.
	 *
	 * @param int $scope The value of on of the predefined `SCOPE_*` constants.
	 * @return PHPMethod This object instance to provide a fluent interface.
	 */
	public function setScope($scope) {

		$this->scope = $scope;

		return $this;
	}

	/**
	 * Gets the scope of the method.
	 *
	 * @return int The value of on of the predefined `SCOPE_*` constants.
	 */
	public function getScope() {

		return $this->scope;
	}

	/**
	 * Sets the body of the method.
	 *
	 * @param PHPRawCode $body A `PHPRawCode` object which contains the body of the method.
	 * @return PHPMethod This object instance to provide a fluent interface.
	 */
	public function setBody(PHPRawCode $body) {

		$this->body = $body;

		return $this;
	}

	/**
	 * Gets the body of the method.
	 *
	 * @return PHPRawCode A `PHPRawCode` object which contains the body of the method.
	 */
	public function getBody() {

		return $this->body;
	}

	/**
	 * Generate the method and return it.
	 *
	 * @return string The generated method.
	 * @throws \com\mohiva\manitou\exceptions\UnexpectedScopeException if an unexpected scope value was given.
	 */
	public function generate() {

		if ($this->scope == self::SCOPE_CLASS) {
			return $this->generateClassMethod();
		} else if ($this->scope == self::SCOPE_INTERFACE) {
			return $this->generateInterfaceMethod();
		}

		throw new UnexpectedScopeException("No scope constant with the value `{$this->scope}` defined");
	}

	/**
	 * Generate a class method.
	 *
	 * @return string A class method declaration.
	 * @throws \com\mohiva\manitou\exceptions\FinalAbstractClassMethodException if an abstract method uses
	 * final keyword.
	 *
	 * @throws \com\mohiva\manitou\exceptions\StaticAbstractClassMethodException if an abstract method uses
	 * static keyword.
	 *
	 * @throws \com\mohiva\manitou\exceptions\AbstractClassMethodContainsBodyException if an abstract method
	 * contains body.
	 */
	protected function generateClassMethod() {

		if ($this->isAbstract && $this->isFinal) {
			throw new FinalAbstractClassMethodException('Cannot use final keyword for abstract method');
		} else if ($this->isAbstract && $this->isStatic) {
			throw new StaticAbstractClassMethodException('Cannot use static keyword for abstract method');
		} else if ($this->isAbstract && $this->body) {
			throw new AbstractClassMethodContainsBodyException('An abstract method cannot contain body');
		}

		$visibility = $this->getVisibilityKeyword();

		$lineFeed = self::getConfig()->getNewline();
		$code  = $this->generateDocBlock();
		$code .= $this->isAbstract ? 'abstract ' : '';
		$code .= $this->isFinal ? 'final ' : '';
		$code .= $visibility . ' ';
		$code .= $this->isStatic ? 'static ' : '';
		$code .= 'function ' . $this->name . '(' . $this->generateParameterList() . ')';
		$code .= $this->isAbstract ? ';' : ' {';
		$code .= $this->body ? $lineFeed : '';
		$code .= $this->generateBody();
		$code .= $this->isAbstract ? $lineFeed : '}' . $lineFeed;

		return $code;
	}

	/**
	 * Generate a interface method.
	 *
	 * @return string A interface method declaration.
	 * @throws \com\mohiva\manitou\exceptions\AbstractInterfaceMethodException if an interface method
	 * uses abstract keyword.
	 *
	 * @throws \com\mohiva\manitou\exceptions\FinalInterfaceMethodException if an interface method uses
	 * final keyword.
	 *
	 * @throws \com\mohiva\manitou\exceptions\InterfaceMethodContainsBodyException if an interface method
	 * contains body.
	 */
	protected function generateInterfaceMethod() {

		if ($this->isAbstract) {
			throw new AbstractInterfaceMethodException('Cannot use abstract keyword for interface method');
		} else if ($this->isFinal) {
			throw new FinalInterfaceMethodException('Cannot use final keyword for interface method');
		} else if ($this->body) {
			throw new InterfaceMethodContainsBodyException('An interface method cannot contain body');
		}

		$visibility = $this->getVisibilityKeyword();

		$lineFeed = self::getConfig()->getNewline();
		$code  = $this->generateDocBlock();
		$code .= $visibility . ' ';
		$code .= $this->isStatic ? 'static ' : '';
		$code .= 'function ' . $this->name . '(' . $this->generateParameterList() . ');' . $lineFeed;

		return $code;
	}

	/**
	 * Generate the parameter list part of this method.
	 *
	 * @return string The parameter list or an empty string if no parameters are set.
	 */
	protected function generateParameterList() {

		if (!$this->parameters) {
			return '';
		}

		$list = array();
		foreach ($this->parameters as $parameter) {
			/* @var \com\mohiva\manitou\generators\php\PHPParameter $parameter */
			$list[] = $parameter->generate();
		}

		return implode(', ', $list);
	}

	/**
	 * Generate the body part of this method.
	 *
	 * @return string The body or an empty string if no body is set.
	 */
	protected function generateBody() {

		if (!$this->body) {
			return '';
		}

		$lineFeed = self::getConfig()->getNewline();
		$body  = $lineFeed;
		$body .= rtrim($this->body->generate(), $lineFeed);
		$body .= $lineFeed;

		$body = $this->indent($body);

		return $body;
	}
}
