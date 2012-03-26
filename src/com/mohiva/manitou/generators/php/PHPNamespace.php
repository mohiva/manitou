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
use com\mohiva\manitou\exceptions\GlobalNamespaceWithoutBracesException;

/**
 * Generates the source code for a namespace.
 *
 * A namespace consists of use statements and classes/interfaces.
 *
 * @category  Mohiva/Manitou
 * @package   Mohiva/Manitou/Exceptions
 * @author    Christian Kaps <christian.kaps@mohiva.com>
 * @copyright Copyright (c) 2007-2012 Christian Kaps (http://www.mohiva.com)
 * @license   https://github.com/mohiva/manitou/blob/master/LICENSE.textile New BSD License
 * @link      https://github.com/mohiva/manitou
 */
class PHPNamespace extends Generator {

	/**
	 * The namespace name.
	 *
	 * @var string
	 */
	protected $name = null;

	/**
	 * Indicates if the bracketed syntax should be used.
	 *
	 * @var boolean
	 * @see http://www.php.net/manual/en/language.namespaces.definitionmultiple.php
	 */
	protected $isBracketed = false;

	/**
	 * A list of use statements.
	 *
	 * @var array
	 */
	protected $useStatements = array();

	/**
	 * A list of classes contained in this namespace.
	 *
	 * @var array
	 */
	protected $classes = array();

	/**
	 * A list of interfaces contained in this namespace.
	 *
	 * @var array
	 */
	protected $interfaces = array();

	/**
	 * The class constructor.
	 *
	 * @param string $name The namespace name or null for the global namespace.
	 * @param boolean $isBracketed True if the bracketed syntax should be used, false otherwise.
	 */
	public function __construct($name = null, $isBracketed = false) {

		$this->isBracketed = $isBracketed;
		$this->setName($name);
	}

	/**
	 * Sets the namespace name.
	 *
	 * @param string $name The namespace name or null for the global namespace.
	 * @return PHPNamespace This object instance to provide a fluent interface.
	 */
	public function setName($name) {

		$this->name = trim($name, '\\');

		return $this;
	}

	/**
	 * Gets the namespace name.
	 *
	 * @return string The namespace name or null for the global namespace.
	 */
	public function getName() {

		return $this->name;
	}

	/**
	 * Defines if the namespace is bracketed or not.
	 *
	 * @param boolean $isBracketed True if the bracketed syntax should be used, false otherwise.
	 * @return PHPNamespace This object instance to provide a fluent interface.
	 */
	public function setBracketed($isBracketed) {

		$this->isBracketed = $isBracketed;

		return $this;
	}

	/**
	 * Indicates if the namespace is bracketed or not.
	 *
	 * @return boolean True if the bracketed syntax should be used, false otherwise.
	 */
	public function isBracketed() {

		return $this->isBracketed;
	}

	/**
	 * Sets a list with `PHPUse` objects.
	 *
	 * @param array $useStatements A list with `PHPUse` objects.
	 * @return PHPNamespace This object instance to provide a fluent interface.
	 */
	public function setUseStatements(array $useStatements) {

		$this->useStatements = array();
		foreach ($useStatements as $use) {
			$this->addUseStatement($use);
		}

		return $this;
	}

	/**
	 * Returns the list with all defined `PHPUse` objects.
	 *
	 * @return array A list with `PHPUse` objects.
	 */
	public function getUseStatements() {

		return $this->useStatements;
	}

	/**
	 * Add a new use statement to the `$useStatements` list.
	 *
	 * @param PHPUse $useStatement The use statement object to add.
	 * @return PHPNamespace This object instance to provide a fluent interface.
	 */
	public function addUseStatement(PHPUse $useStatement) {

		$this->useStatements[spl_object_hash($useStatement)] = $useStatement;

		return $this;
	}

	/**
	 * Remove a use statement from the `$useStatements` list.
	 *
	 * @param PHPUse $useStatement The use statement object to remove.
	 * @return PHPNamespace This object instance to provide a fluent interface.
	 */
	public function removeUseStatement(PHPUse $useStatement) {

		$id = spl_object_hash($useStatement);
		if (isset($this->useStatements[$id])) {
			unset($this->useStatements[$id]);
		}

		return $this;
	}

	/**
	 * Sets a list with `PHPClass` objects.
	 *
	 * @param array $classes A list with `PHPClass` objects.
	 * @return PHPNamespace This object instance to provide a fluent interface.
	 */
	public function setClasses(array $classes) {

		$this->classes = array();
		foreach ($classes as $class) {
			$this->addClass($class);
		}

		return $this;
	}

	/**
	 * Returns the list with all defined `PHPClass` objects.
	 *
	 * @return array A list with `PHPClass` objects.
	 */
	public function getClasses() {

		return $this->classes;
	}

	/**
	 * Add a new class to the `$classes` list.
	 *
	 * @param PHPClass $class The class object to add.
	 * @return PHPNamespace This object instance to provide a fluent interface.
	 */
	public function addClass(PHPClass $class) {

		$this->classes[spl_object_hash($class)] = $class;

		return $this;
	}

	/**
	 * Remove a class from the `$classes` list.
	 *
	 * @param PHPClass $class The class object to remove.
	 * @return PHPNamespace This object instance to provide a fluent interface.
	 */
	public function removeClass(PHPClass $class) {

		$id = spl_object_hash($class);
		if (isset($this->classes[$id])) {
			unset($this->classes[$id]);
		}

		return $this;
	}

	/**
	 * Sets a list with `PHPInterface` objects.
	 *
	 * @param array $interfaces A list with `PHPInterface` objects.
	 * @return PHPNamespace This object instance to provide a fluent interface.
	 */
	public function setInterfaces(array $interfaces) {

		$this->interfaces = array();
		foreach ($interfaces as $interface) {
			$this->addInterface($interface);
		}

		return $this;
	}

	/**
	 * Returns the list with all defined `PHPInterface` objects.
	 *
	 * @return array A list with `PHPInterface` objects.
	 */
	public function getInterfaces() {

		return $this->interfaces;
	}

	/**
	 * Add a new interface to the `$interfaces` list.
	 *
	 * @param PHPInterface $interface The interface object to add.
	 * @return PHPNamespace This object instance to provide a fluent interface.
	 */
	public function addInterface(PHPInterface $interface) {

		$this->interfaces[spl_object_hash($interface)] = $interface;

		return $this;
	}

	/**
	 * Remove a interface from the `$interfaces` list.
	 *
	 * @param PHPInterface $interface The interface object to remove.
	 * @return PHPNamespace This object instance to provide a fluent interface.
	 */
	public function removeInterface(PHPInterface $interface) {

		$id = spl_object_hash($interface);
		if (isset($this->interfaces[$id])) {
			unset($this->interfaces[$id]);
		}

		return $this;
	}

	/**
	 * Generate the namespace definition and return it.
	 *
	 * @return string The generated namespace definition.
	 * @throws \com\mohiva\manitou\exceptions\GlobalNamespaceWithoutBracesException if the namespace is
	 * global and no braces are used.
	 */
	public function generate() {

		if (!$this->name && !$this->isBracketed) {
			throw new GlobalNamespaceWithoutBracesException(
				'A global namespace definition can only be used with braces'
			);
		} else if ($this->isBracketed) {
			return $this->generateNamespaceWithBraces();
		}

		return $this->generateNamespaceWithoutBraces();
	}

	/**
	 * Generate a namespace definition with braces. The definition consists
	 * of the namespace definition itself and additionally of use statements,
	 * classes and interfaces.
	 *
	 * @return string The complete namespace definition containing additionally use statements, classes and interfaces.
	 */
	protected function generateNamespaceWithBraces() {

		$body  = $this->generateUseStaments();
		$body .= $this->generateClasses();
		$body .= $this->generateInterfaces();

		$lineFeed = self::getConfig()->getNewline();
		$code  = 'namespace ' . ($this->name ? $this->name . ' ' : '');
		$code .= '{' . ($body ? $lineFeed : '');
		$code .= $body ? $this->indent($body) : '';
		$code .= '}' . $lineFeed;

		return $code;
	}

	/**
	 * Generate a namespace definition without braces. The definition consists
	 * of the namespace definition itself and additionally of use statements
	 * and classes.
	 *
	 * @return string The complete namespace definition containing additionally use statements and classes.
	 */
	protected function generateNamespaceWithoutBraces() {

		$lineFeed = self::getConfig()->getNewline();
		$code  = 'namespace ' . $this->name . ';' . $lineFeed;
		$code .= $this->generateUseStaments();
		$code .= $this->generateClasses();
		$code .= $this->generateInterfaces();

		return $code;
	}

	/**
	 * Generate the use statement part of this namespace.
	 *
	 * @return string The content of all set use statements or an empty string if no use statements are set.
	 */
	protected function generateUseStaments() {

		if (!$this->useStatements) {
			return '';
		}

		$lineFeed = self::getConfig()->getNewline();
		$code = $lineFeed;
		foreach ($this->useStatements as $use) {
			/* @var \com\mohiva\manitou\generators\php\PHPUse $use */
			$code .= $use->generate();
		}

		return $code;
	}

	/**
	 * Generate the class part of this namespace.
	 *
	 * @return string The content of all set classes or an empty string if no classes are set.
	 */
	protected function generateClasses() {

		if (!$this->classes) {
			return '';
		}

		$code = '';
		$lineFeed = self::getConfig()->getNewline();
		foreach ($this->classes as $class) {
			/* @var \com\mohiva\manitou\generators\php\PHPClass $class */
			$code .= $lineFeed;
			$code .= $class->generate();
		}

		return $code;
	}

	/**
	 * Generate the interface part of this namespace.
	 *
	 * @return string The content of all set interfaces or an empty string if no interfaces are set.
	 */
	protected function generateInterfaces() {

		if (!$this->interfaces) {
			return '';
		}

		$code = '';
		$lineFeed = self::getConfig()->getNewline();
		foreach ($this->interfaces as $interface) {
			/* @var \com\mohiva\manitou\generators\php\PHPInterface $interface */
			$code .= $lineFeed;
			$code .= $interface->generate();
		}

		return $code;
	}
}
