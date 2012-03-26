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

use com\mohiva\manitou\Generator;

/**
 * Generates the source code for an interface.
 *
 * @category  Mohiva/Manitou
 * @package   Mohiva/Manitou/Exceptions
 * @author    Christian Kaps <christian.kaps@mohiva.com>
 * @copyright Copyright (c) 2007-2012 Christian Kaps (http://www.mohiva.com)
 * @license   https://github.com/mohiva/manitou/blob/master/LICENSE.textile New BSD License
 * @link      https://github.com/mohiva/manitou
 */
class PHPInterface extends Generator {

	/**
	 * The name of the interface.
	 *
	 * @var string
	 */
	protected $name = null;

	/**
	 * A list of inherited interfaces.
	 *
	 * @var array
	 */
	protected $parentInterfaces = array();

	/**
	 * A list of interface constants.
	 *
	 * @var array
	 */
	protected $constants = array();

	/**
	 * A list of methods contained in this interface.
	 *
	 * @var array
	 */
	protected $methods = array();

	/**
	 * The interface DocBlock.
	 *
	 * @var PHPDocBlock
	 */
	protected $docBlock = null;

	/**
	 * The class constructor.
	 *
	 * @param string $name The name of the interface.
	 * @param array $parentInterfaces A list of inherited interfaces.
	 */
	public function __construct($name, array $parentInterfaces = array()) {

		$this->name = $name;
		$this->setParentInterfaces($parentInterfaces);
	}

	/**
	 * Sets the name of the interface.
	 *
	 * @param string $name The name of the interface.
	 * @return PHPInterface This object instance to provide a fluent interface.
	 */
	public function setName($name) {

		$this->name = $name;

		return $this;
	}

	/**
	 * Gets the name of the interface.
	 *
	 * @return string The name of the interface.
	 */
	public function getName() {

		return $this->name;
	}

	/**
	 * Sets a list of interfaces to inherit.
	 *
	 * @param array $parentInterfaces A list of interfaces to inherit.
	 * @return PHPInterface This object instance to provide a fluent interface.
	 */
	public function setParentInterfaces(array $parentInterfaces) {

		$this->parentInterfaces = array();
		foreach ($parentInterfaces as $interface) {
			$this->addParentInterface($interface);
		}

		return $this;
	}

	/**
	 * Gets the list of all inherited interfaces.
	 *
	 * @return array A list of inherited interfaces.
	 */
	public function getParentInterfaces() {

		return $this->parentInterfaces;
	}

	/**
	 * Add a new inherited interface to the `$parentInterfaces` list.
	 *
	 * @param string $interface The inherited interface to add.
	 * @return PHPInterface This object instance to provide a fluent interface.
	 */
	public function addParentInterface($interface) {

		$this->parentInterfaces[sha1($interface)] = $interface;

		return $this;
	}

	/**
	 * Remove a inherited interface from the `$parentInterfaces` list.
	 *
	 * @param string $interface The inherited interface to remove.
	 * @return PHPInterface This object instance to provide a fluent interface.
	 */
	public function removeParentInterface($interface) {

		$id = sha1($interface);
		if (isset($this->parentInterfaces[$id])) {
			unset($this->parentInterfaces[$id]);
		}

		return $this;
	}

	/**
	 * Sets a list with `PHPConstant` objects.
	 *
	 * @param array $constants A list with `PHPConstant` objects.
	 * @return PHPInterface This object instance to provide a fluent interface.
	 */
	public function setConstants(array $constants) {

		$this->constants = array();
		foreach ($constants as $constant) {
			$this->addConstant($constant);
		}

		return $this;
	}

	/**
	 * Gets the list with all defined `PHPConstant` objects.
	 *
	 * @return array A list with `PHPConstant` objects.
	 */
	public function getConstants() {

		return $this->constants;
	}

	/**
	 * Add a new constant to the `$constants` list.
	 *
	 * @param PHPConstant $constant The constant to add.
	 * @return PHPInterface This object instance to provide a fluent interface.
	 */
	public function addConstant(PHPConstant $constant) {

		$this->constants[spl_object_hash($constant)] = $constant;

		return $this;
	}

	/**
	 * Remove a constant from the `$constants` list.
	 *
	 * @param PHPConstant $constant The constant to remove.
	 * @return PHPInterface This object instance to provide a fluent interface.
	 */
	public function removeConstant(PHPConstant $constant) {

		$id = spl_object_hash($constant);
		if (isset($this->constants[$id])) {
			unset($this->constants[$id]);
		}

		return $this;
	}

	/**
	 * Sets a list with `PHPMethod` objects.
	 *
	 * @param array $methods A list with `PHPMethod` objects.
	 * @return PHPInterface This object instance to provide a fluent interface.
	 */
	public function setMethods(array $methods) {

		$this->methods = array();
		foreach ($methods as $method) {
			$this->addMethod($method);
		}

		return $this;
	}

	/**
	 * Gets the list with all defined `PHPMethod` objects.
	 *
	 * @return array A list with `PHPMethod` objects.
	 */
	public function getMethods() {

		return $this->methods;
	}

	/**
	 * Add a new method to the `$methods` list.
	 *
	 * @param PHPMethod $method The method to add.
	 * @return PHPInterface This object instance to provide a fluent interface.
	 */
	public function addMethod(PHPMethod $method) {

		$this->methods[spl_object_hash($method)] = $method;

		return $this;
	}

	/**
	 * Remove a method from the `$methods` list.
	 *
	 * @param PHPMethod $method The method to remove.
	 * @return PHPInterface This object instance to provide a fluent interface.
	 */
	public function removeMethod(PHPMethod $method) {

		$id = spl_object_hash($method);
		if (isset($this->methods[$id])) {
			unset($this->methods[$id]);
		}

		return $this;
	}

	/**
	 * Sets the DocBlock object for this interface.
	 *
	 * @param PHPDocBlock $docBlock The DocBlock object for this interface.
	 * @return PHPInterface This object instance to provide a fluent interface.
	 */
	public function setDocBlock(PHPDocBlock $docBlock) {

		$this->docBlock = $docBlock;

		return $this;
	}

	/**
	 * Gets the DocBlock object for this interface.
	 *
	 * @return PHPDocBlock The DocBlock object for this interface.
	 */
	public function getDocBlock() {

		return $this->docBlock;
	}

	/**
	 * Generate the interface declaration and return it.
	 *
	 * @return string The generated interface declaration.
	 */
	public function generate() {

		$body = $this->generateBody();

		$lineFeed = self::getConfig()->getNewline();
		$code  = $this->generateDocBlock();
		$code .= 'interface ' . $this->name;
		$code .= $this->generateParentInterfaces();
		$code .= ' {';
		$code .= $body ? $lineFeed : '';
		$code .= $body;
		$code .= '}' . $lineFeed;

		return $code;
	}

	/**
	 * Generate the DocBlock part of this interface.
	 *
	 * @return string The DocBlock content or an empty string if no DocBlock is set.
	 */
	protected function generateDocBlock() {

		if (!$this->docBlock) {
			return '';
		}

		$code = $this->docBlock->generate();

		return $code;
	}

	/**
	 * Generate the parents part of this class.
	 *
	 * @return string The parents definition or an empty string if no parents are set.
	 */
	protected function generateParentInterfaces() {

		if (!$this->parentInterfaces) {
			return '';
		}

		$code  = ' extends ';
		$code .= implode(', ', $this->parentInterfaces);

		return $code;
	}

	/**
	 * Generate the body part of this class.
	 *
	 * @return string The body or an empty string if no constants, properties or methods are set.
	 */
	protected function generateBody() {

		if (!$this->constants &&
			!$this->methods) {

			return '';
		}

		$code  = $this->generateConstants();
		$code .= $this->generateMethods();

		return $this->indent($code);
	}

	/**
	 * Generate the constants part of this class.
	 *
	 * @return string The constants part or an empty string if no constants are set.
	 */
	protected function generateConstants() {

		if (!$this->constants) {
			return '';
		}

		$code = '';
		$lineFeed = self::getConfig()->getNewline();
		foreach ($this->constants as $constant) {
			/* @var \com\mohiva\manitou\generators\php\PHPConstant $constant */
			$code .= $lineFeed;
			$code .= $constant->generate();
		}

		return $code;
	}

	/**
	 * Generate the methods part of this class. This method set automatically
	 * the scope of the method to `PHPMethod::SCOPE_INTERFACE`.
	 *
	 * @return string The methods part or an empty string if no methods are set.
	 */
	protected function generateMethods() {

		if (!$this->methods) {
			return '';
		}

		$code = '';
		$lineFeed = self::getConfig()->getNewline();
		foreach ($this->methods as $method) {
			/* @var \com\mohiva\manitou\generators\php\PHPMethod $method */
			$method->setScope(PHPMEthod::SCOPE_INTERFACE);
			$code .= $lineFeed;
			$code .= $method->generate();
		}

		return $code;
	}
}
