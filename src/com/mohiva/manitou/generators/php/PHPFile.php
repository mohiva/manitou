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
use com\mohiva\manitou\exceptions\FileGenerationException;
use com\mohiva\manitou\exceptions\WrongNamespaceCombinationException;

/**
 * Generates the content of a file.
 * 
 * It is only supported to set classes or namespaces. Both together ends in 
 * unusable code. So an exception will be thrown in this situation.
 * 
 * @category  Mohiva/Manitou
 * @package   Mohiva/Manitou/Exceptions
 * @author    Christian Kaps <christian.kaps@mohiva.com>
 * @copyright Copyright (c) 2007-2012 Christian Kaps (http://www.mohiva.com)
 * @license   https://github.com/mohiva/manitou/blob/master/LICENSE.textile New BSD License
 * @link      https://github.com/mohiva/manitou
 */
class PHPFile extends Generator {
	
	/**
	 * The file-level DocBlock.
	 * 
	 * @var PHPDocBlock
	 */
	protected $docBlock = null;
	
	/**
	 * A list of namespaces contained in this file.
	 * 
	 * @var array
	 */
	protected $namespaces = array();
	
	/**
	 * A list of classes contained in this file.
	 * 
	 * @var array
	 */
	protected $classes = array();
	
	/**
	 * A list of interfaces contained in this file.
	 * 
	 * @var array
	 */
	protected $interfaces = array();
	
	/**
	 * Create an instance of this class and return it. This method 
	 * exists to provide a fluent interface.
	 * 
	 * @return PHPFile An instance of this class.
	 */
	public static function create() {
		
		$class = new self();
		
		return $class;
	}
	
	/**
	 * Sets the DocBlock object for this file.
	 * 
	 * @param PHPDocBlock $docBlock The DocBlock object for this file.
	 * @return PHPFile This object instance to provide a fluent interface.
	 */
	public function setDocBlock(PHPDocBlock $docBlock) {
		
		$this->docBlock = $docBlock;
		
		return $this;
	}
	
	/**
	 * Gets the DocBlock object for this file.
	 * 
	 * @return PHPDocBlock The DocBlock object for this file.
	 */
	public function getDocBlock() {
		
		return $this->docBlock;
	}
	
	/**
	 * Sets a list with `PHPNamespace` objects.
	 * 
	 * @param array $namespaces A list with `PHPNamespace` objects.
	 * @return PHPFile This object instance to provide a fluent interface.
	 */
	public function setNamespaces(array $namespaces) {
		
		$this->namespaces = array();
		foreach ($namespaces as $namespace) {
			$this->addNamespace($namespace);
		}
		
		return $this;
	}
	
	/**
	 * Gets the list with all defined `PHPNamespace` objects.
	 * 
	 * @return array A list with `PHPNamespace` objects.
	 */
	public function getNamespaces() {
		
		return $this->namespaces;
	}
	
	/**
	 * Add a new namespace to the `$namespaces` list.
	 * 
	 * @param PHPNamespace $namespace The namespace object to add.
	 * @return PHPFile This object instance to provide a fluent interface.
	 */
	public function addNamespace(PHPNamespace $namespace) {
		
		$this->namespaces[spl_object_hash($namespace)] = $namespace;
		
		return $this;
	}
	
	/**
	 * Remove a namespace from the `$namespaces` list.
	 * 
	 * @param PHPNamespace $namespace The namespace object to remove.
	 * @return PHPFile This object instance to provide a fluent interface.
	 */
	public function removeNamespace(PHPNamespace $namespace) {
		
		$id = spl_object_hash($namespace);
		if (isset($this->namespaces[$id])) {
			unset($this->namespaces[$id]);
		}
		
		return $this;
	}
	
	/**
	 * Sets a list with `PHPClass` objects.
	 * 
	 * @param array $classes A list with `PHPClass` objects.
	 * @return PHPFile This object instance to provide a fluent interface.
	 */
	public function setClasses(array $classes) {
		
		$this->classes = array();
		foreach ($classes as $class) {
			$this->addClass($class);
		}
		
		return $this;
	}
	
	/**
	 * Gets the list with all defined `PHPClass` objects.
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
	 * @return PHPFile This object instance to provide a fluent interface.
	 */
	public function addClass(PHPClass $class) {
		
		$this->classes[spl_object_hash($class)] = $class;
		
		return $this;
	}
	
	/**
	 * Remove a class from the `$classes` list.
	 * 
	 * @param PHPClass $class The class object to remove.
	 * @return PHPFile This object instance to provide a fluent interface.
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
	 * @return PHPFile This object instance to provide a fluent interface.
	 */
	public function setInterfaces(array $interfaces) {
		
		$this->interfaces = array();
		foreach ($interfaces as $interface) {
			$this->addInterface($interface);
		}
		
		return $this;
	}
	
	/**
	 * Gets the list with all defined `PHPInterface` objects.
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
	 * @return PHPFile This object instance to provide a fluent interface.
	 */
	public function addInterface(PHPInterface $interface) {
		
		$this->interfaces[spl_object_hash($interface)] = $interface;
		
		return $this;
	}
	
	/**
	 * Remove a interface from the `$interfaces` list.
	 * 
	 * @param PHPInterface $interface The interface object to remove.
	 * @return PHPFile This object instance to provide a fluent interface.
	 */
	public function removeInterface(PHPInterface $interface) {
		
		$id = spl_object_hash($interface);
		if (isset($this->interfaces[$id])) {
			unset($this->interfaces[$id]);
		}
		
		return $this;
	}
	
	/**
	 * Generate the file content and return it.
	 * 
	 * @return string The generated file content.
	 * @throws FileGenerationException if namespaces and classes are set for this file.
	 */
	public function generate() {
		
		if ($this->namespaces && ($this->classes || $this->interfaces)) {
			throw new FileGenerationException(
				'It is not allowed to mix namespaces with classes or interfaces, please ' .
				'add this classes or interfaces to the namespace generator class.'
			);
		}
		
		$code  = '<?php' . self::LINE_FEED;
		$code .= $this->generateDocBlock();
		$code .= $this->generateNamespaces();
		$code .= $this->generateClasses();
		$code .= $this->generateInterfaces();
		
		return $code;
	}
	
	/**
	 * Generate the DocBlock part of this file.
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
	 * Generate the namespace part of this file.
	 * 
	 * @return string The content of all set namespaces or an empty string if no namespaces are set.
	 * @throws WrongNamespaceCombinationException if multiple namespaces in a file doesn't use the 
	 * same(braced or non-braced) syntax.
	 */
	protected function generateNamespaces() {
		
		if (!$this->namespaces) {
			return '';
		}
		
		$braced = false;
		$nonBraced = false;
		$code = $this->docBlock ? '' : self::LINE_FEED;
		foreach ($this->namespaces as $namespace) {
			/* @var \com\mohiva\manitou\generators\php\PHPNamespace $namespace */
			if (!$braced && $namespace->isBracketed()) {
				$braced = true;
			} else if (!$nonBraced && !$namespace->isBracketed()) {
				$nonBraced = true;
			}
			
			$code .= $namespace->generate();
			$code .= self::LINE_FEED;
		}
		
		// Checks for wrong namespace combination
		if ($braced && $nonBraced) {
			throw new WrongNamespaceCombinationException(
				'Multiple namespaces in a file should use same (preferably braced) syntax'
			);
		}
		
		$code  = rtrim($code, self::LINE_FEED);
		$code .= self::LINE_FEED;
		
		return $code;
	}
	
	/**
	 * Generate the class part of this file.
	 * 
	 * @return string The content of all set classes or an empty string if no classes are set.
	 */
	protected function generateClasses() {
		
		if (!$this->classes) {
			return '';
		}
		
		$code = self::LINE_FEED;
		foreach ($this->classes as $class) {
			/* @var \com\mohiva\manitou\generators\php\PHPClass $class */
			$code .= $class->generate();
			$code .= self::LINE_FEED;
		}
		
		$code  = rtrim($code, self::LINE_FEED);
		$code .= self::LINE_FEED;
		
		return $code;
	}
	
	/**
	 * Generate the interfaces part of this file.
	 * 
	 * @return string The content of all set interfaces or an empty string if no interfaces are set.
	 */
	protected function generateInterfaces() {
		
		if (!$this->interfaces) {
			return '';
		}
		
		$code = self::LINE_FEED;
		foreach ($this->interfaces as $interface) {
			/* @var \com\mohiva\manitou\generators\php\PHPInterface $interface */
			$code .= $interface->generate();
			$code .= self::LINE_FEED;
		}
		
		$code  = rtrim($code, self::LINE_FEED);
		$code .= self::LINE_FEED;
		
		return $code;
	}
}
