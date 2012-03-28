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
 * @package   Mohiva/Manitou/Generators
 * @author    Christian Kaps <christian.kaps@mohiva.com>
 * @copyright Copyright (c) 2007-2012 Christian Kaps (http://www.mohiva.com)
 * @license   https://github.com/mohiva/manitou/blob/master/LICENSE.textile New BSD License
 * @link      https://github.com/mohiva/manitou
 */
namespace com\mohiva\manitou\generators\php;

use com\mohiva\manitou\Generator;
use com\mohiva\manitou\exceptions\FinalAbstractClassException;

/**
 * Generates the source code for a class.
 *
 * @category  Mohiva/Manitou
 * @package   Mohiva/Manitou/Generators
 * @author    Christian Kaps <christian.kaps@mohiva.com>
 * @copyright Copyright (c) 2007-2012 Christian Kaps (http://www.mohiva.com)
 * @license   https://github.com/mohiva/manitou/blob/master/LICENSE.textile New BSD License
 * @link      https://github.com/mohiva/manitou
 */
class PHPClass extends Generator {

	/**
	 * The name of the class.
	 *
	 * @var string
	 */
	private $name = null;

	/**
	 * Indicates if the class is abstract or not.
	 *
	 * @var boolean
	 */
	private $isAbstract = false;

	/**
	 * Indicates if the class is final or not.
	 *
	 * @var boolean
	 */
	private $isFinal = false;

	/**
	 * The name of a class to inherit.
	 *
	 * @var string
	 */
	private $parentClass = null;

	/**
	 * A list of implemented interfaces.
	 *
	 * @var array
	 */
	private $implInterfaces = array();

	/**
	 * A list of class constants.
	 *
	 * @var array
	 */
	private $constants = array();

	/**
	 * A list of properties contained in this class.
	 *
	 * @var array
	 */
	private $properties = array();

	/**
	 * A list of methods contained in this class.
	 *
	 * @var array
	 */
	private $methods = array();

	/**
	 * The class DocBlock.
	 *
	 * @var PHPDocBlock
	 */
	private $docBlock = null;

	/**
	 * The class constructor.
	 *
	 * @param string $name The name of the class.
	 * @param string $parentClass The name of a class to inherit.
	 * @param array $implInterfaces A list of implemented interfaces.
	 * @param boolean $isAbstract True if the class is abstract, false otherwise.
	 * @param boolean $isFinal True if the class is final, false otherwise.
	 */
	public function __construct(
		$name,
		$parentClass = null,
		array $implInterfaces = array(),
		$isAbstract = false,
		$isFinal = false) {

		$this->name = $name;
		$this->parentClass = $parentClass;
		$this->isAbstract = $isAbstract;
		$this->isFinal = $isFinal;
		$this->setImplInterfaces($implInterfaces);
	}

	/**
	 * Sets the name of the class.
	 *
	 * @param string $name The name of the class.
	 * @return PHPClass This object instance to provide a fluent interface.
	 */
	public function setName($name) {

		$this->name = $name;

		return $this;
	}

	/**
	 * Gets the name of the class.
	 *
	 * @return string The name of the class.
	 */
	public function getName() {

		return $this->name;
	}

	/**
	 * Sets the name of a class to inherit.
	 *
	 * @param string $parentClass The name of a class to inherit.
	 * @return PHPClass This object instance to provide a fluent interface.
	 */
	public function setParentClass($parentClass) {

		$this->parentClass = $parentClass;

		return $this;
	}

	/**
	 * Gets the name of a class to inherit.
	 *
	 * @return string The name of a class to inherit.
	 */
	public function getParentClass() {

		return $this->parentClass;
	}

	/**
	 * Sets the list of interfaces to implement.
	 *
	 * @param array $implInterfaces A list of interfaces to implement.
	 * @return PHPClass This object instance to provide a fluent interface.
	 */
	public function setImplInterfaces(array $implInterfaces) {

		$this->implInterfaces = array();
		foreach ($implInterfaces as $interface) {
			$this->addImplInterface($interface);
		}

		return $this;
	}

	/**
	 * Gets the list of implemented interfaces.
	 *
	 * @return array The list of implemented interfaces.
	 */
	public function getImplInterfaces() {

		return $this->implInterfaces;
	}

	/**
	 * Add a new interface to the `$implInterfaces` list.
	 *
	 * @param string $interface The interface to add.
	 * @return PHPClass This object instance to provide a fluent interface.
	 */
	public function addImplInterface($interface) {

		$this->implInterfaces[sha1($interface)] = $interface;

		return $this;
	}

	/**
	 * Remove an interface from the `$implInterfaces` list.
	 *
	 * @param string $interface The interface to remove.
	 * @return PHPClass This object instance to provide a fluent interface.
	 */
	public function removeImplInterface($interface) {

		$id = sha1($interface);
		if (isset($this->implInterfaces[$id])) {
			unset($this->implInterfaces[$id]);
		}

		return $this;
	}

	/**
	 * Defines if the class is abstract or not.
	 *
	 * @param boolean $isAbstract True if the class is abstract, false otherwise.
	 * @return PHPClass This object instance to provide a fluent interface.
	 */
	public function setAbstract($isAbstract) {

		$this->isAbstract = $isAbstract;

		return $this;
	}

	/**
	 * Indicates if the class is abstract or not.
	 *
	 * @return boolean True if the class is abstract, false otherwise.
	 */
	public function isAbstract() {

		return $this->isAbstract;
	}

	/**
	 * Defines if the class is final or not.
	 *
	 * @param boolean $isFinal True if the class is final, false otherwise.
	 * @return PHPClass This object instance to provide a fluent interface.
	 */
	public function setFinal($isFinal) {

		$this->isFinal = $isFinal;

		return $this;
	}

	/**
	 * Indicates if the class is final or not.
	 *
	 * @return boolean True if the class is final, false otherwise.
	 */
	public function isFinal() {

		return $this->isFinal;
	}

	/**
	 * Sets a list with `PHPConstant`> objects.
	 *
	 * @param array $constants A list with `PHPConstant` objects.
	 * @return PHPClass This object instance to provide a fluent interface.
	 */
	public function setConstants(array $constants) {

		$this->constants = array();
		foreach ($constants as $constant) {
			$this->addConstant($constant);
		}

		return $this;
	}

	/**
	 * Gets a list with all defined `PHPConstant` objects.
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
	 * @return PHPClass This object instance to provide a fluent interface.
	 */
	public function addConstant(PHPConstant $constant) {

		$this->constants[spl_object_hash($constant)] = $constant;

		return $this;
	}

	/**
	 * Remove a constant from the `$constants` list.
	 *
	 * @param PHPConstant $constant The constant to remove.
	 * @return PHPClass This object instance to provide a fluent interface.
	 */
	public function removeConstant(PHPConstant $constant) {

		$id = spl_object_hash($constant);
		if (isset($this->constants[$id])) {
			unset($this->constants[$id]);
		}

		return $this;
	}

	/**
	 * Sets a list with `PHPProperty` objects.
	 *
	 * @param array $properties A list with `PHPProperty` objects.
	 * @return PHPClass This object instance to provide a fluent interface.
	 */
	public function setProperties(array $properties) {

		$this->properties = array();
		foreach ($properties as $property) {
			$this->addProperty($property);
		}

		return $this;
	}

	/**
	 * Gets a list with all defined `PHPProperty` objects.
	 *
	 * @return array A list with `PHPProperty` objects.
	 */
	public function getProperties() {

		return $this->properties;
	}

	/**
	 * Add a new property to the `$properties` list.
	 *
	 * @param PHPProperty $property The property to add.
	 * @return PHPClass This object instance to provide a fluent interface.
	 */
	public function addProperty(PHPProperty $property) {

		$this->properties[spl_object_hash($property)] = $property;

		return $this;
	}

	/**
	 * Remove a property from the `$properties` list.
	 *
	 * @param PHPProperty $property The property to remove.
	 * @return PHPClass This object instance to provide a fluent interface.
	 */
	public function removeProperty(PHPProperty $property) {

		$id = spl_object_hash($property);
		if (isset($this->properties[$id])) {
			unset($this->properties[$id]);
		}

		return $this;
	}

	/**
	 * Sets a list with `PHPMethod` objects.
	 *
	 * @param array $methods A list with `PHPMethod` objects.
	 * @return PHPClass This object instance to provide a fluent interface.
	 */
	public function setMethods(array $methods) {

		$this->methods = array();
		foreach ($methods as $method) {
			$this->addMethod($method);
		}

		return $this;
	}

	/**
	 * Gets a list with all defined `PHPMethod` objects.
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
	 * @return PHPClass This object instance to provide a fluent interface.
	 */
	public function addMethod(PHPMethod $method) {

		$this->methods[spl_object_hash($method)] = $method;

		return $this;
	}

	/**
	 * Remove a method from the `$methods` list.
	 *
	 * @param PHPMethod $method The method to remove.
	 * @return PHPClass This object instance to provide a fluent interface.
	 */
	public function removeMethod(PHPMethod $method) {

		$id = spl_object_hash($method);
		if (isset($this->methods[$id])) {
			unset($this->methods[$id]);
		}

		return $this;
	}

	/**
	 * Sets the DocBlock object for this class.
	 *
	 * @param PHPDocBlock $docBlock The DocBlock object for this class.
	 * @return PHPClass This object instance to provide a fluent interface.
	 */
	public function setDocBlock(PHPDocBlock $docBlock) {

		$this->docBlock = $docBlock;

		return $this;
	}

	/**
	 * Gets the DocBlock object for this class.
	 *
	 * @return PHPDocBlock The DocBlock object for this class.
	 */
	public function getDocBlock() {

		return $this->docBlock;
	}

	/**
	 * Generate the class declaration and return it.
	 *
	 * @return string The generated class declaration.
	 * @throws \com\mohiva\manitou\exceptions\FinalAbstractClassException if the final keyword is used in abstract
	 * class declaration.
	 */
	public function generate() {

		if ($this->isAbstract && $this->isFinal) {
			throw new FinalAbstractClassException('Cannot use final keyword on abstract class declaration');
		}

		$lineFeed = self::getConfig()->getNewline();
		$body = $this->generateBody();

		$code  = $this->generateDocBlock();
		$code .= $this->isAbstract ? 'abstract ' : '';
		$code .= $this->isFinal ? 'final ' : '';
		$code .= 'class ' . $this->name;
		$code .= $this->parentClass ? ' extends ' . $this->parentClass : '';
		$code .= $this->generateImplInterfaces();
		$code .= ' {';
		$code .= $body ? $lineFeed : '';
		$code .= $body;
		$code .= '}' . $lineFeed;

		return $code;
	}

	/**
	 * Generate the DocBlock part of this class.
	 *
	 * @return string The DocBlock content or an empty string if no DocBlock is set.
	 */
	private function generateDocBlock() {

		if (!$this->docBlock) {
			return '';
		}

		$code = $this->docBlock->generate();

		return $code;
	}

	/**
	 * Generate the interfaces part of this class.
	 *
	 * @return string The interface definition or an empty string if no interfaces are set.
	 */
	private function generateImplInterfaces() {

		if (!$this->implInterfaces) {
			return '';
		}

		$code  = ' implements ';
		$code .= implode(', ', $this->implInterfaces);

		return $code;
	}

	/**
	 * Generate the body part of this class.
	 *
	 * @return string The body or an empty string if no constants, properties or methods are set.
	 */
	private function generateBody() {

		if (!$this->constants &&
			!$this->properties &&
			!$this->methods) {

			return '';
		}

		$code  = $this->generateConstants();
		$code .= $this->generateProperties();
		$code .= $this->generateMethods();

		return $this->indent($code);
	}

	/**
	 * Generate the constants part of this class.
	 *
	 * @return string The constants part or an empty string if no constants are set.
	 */
	private function generateConstants() {

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
	 * Generate the properties part of this class.
	 *
	 * @return string The properties part or an empty string if no properties are set.
	 */
	private function generateProperties() {

		if (!$this->properties) {
			return '';
		}

		$code = '';
		$lineFeed = self::getConfig()->getNewline();
		foreach ($this->properties as $property) {
			/* @var \com\mohiva\manitou\generators\php\PHPProperty $property */
			$code .= $lineFeed;
			$code .= $property->generate();
		}

		return $code;
	}

	/**
	 * Generate the methods part of this class. This method set automatically
	 * the scope of the method to `PHPMethod::SCOPE_CLASS`.
	 *
	 * @return string The methods part or an empty string if no methods are set.
	 */
	private function generateMethods() {

		if (!$this->methods) {
			return '';
		}

		$code = '';
		$lineFeed = self::getConfig()->getNewline();
		foreach ($this->methods as $method) {
			/* @var \com\mohiva\manitou\generators\php\PHPMethod $method */
			$method->setScope(PHPMethod::SCOPE_CLASS);
			$code .= $lineFeed;
			$code .= $method->generate();
		}

		return $code;
	}
}
