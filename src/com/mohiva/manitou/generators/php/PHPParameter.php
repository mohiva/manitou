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
 * Generates a the source code for a parameter.
 * 
 * @category  Mohiva/Manitou
 * @package   Mohiva/Manitou/Exceptions
 * @author    Christian Kaps <christian.kaps@mohiva.com>
 * @copyright Copyright (c) 2007-2012 Christian Kaps (http://www.mohiva.com)
 * @license   https://github.com/mohiva/manitou/blob/master/LICENSE.textile New BSD License
 * @link      https://github.com/mohiva/manitou
 */
class PHPParameter extends Generator {
	
	/**
	 * The type of the parameter.
	 * 
	 * @var string
	 */
	protected $type = null;
	
	/**
	 * The name of the parameter.
	 * 
	 * @var string
	 */
	protected $name = null;
	
	/**
	 * The default value of the parameter.
	 * 
	 * @var PHPValue
	 */
	protected $value = null;
	
	/**
	 * Create an instance of this class and return it. This method 
	 * exists to provide a fluent interface.
	 * 
	 * @param string $name The name of the parameter.
	 * @return PHPParameter An instance of this class.
	 */
	public static function create($name) {
		
		$instance = new self($name);
		
		return $instance;
	}
	
	/**
	 * The class constructor.
	 * 
	 * @param string $name The name of the parameter.
	 * @param string $type The type of the parameter.
	 * @param PHPValue $value The value of the parameter.
	 */
	public function __construct($name, $type = null, PHPValue $value = null) {
		
		$this->name = $name;
		$this->type = $type;
		$this->value = $value;
	}
	
	/**
	 * Sets the parameter name.
	 * 
	 * @param string $name The name of the parameter.
	 * @return PHPParameter This object instance to provide a fluent interface.
	 */
	public function setName($name) {
		
		$this->name = $name;
		
		return $this;
	}
	
	/**
	 * Returns the parameter name.
	 * 
	 * @return string The name of the parameter.
	 */
	public function getName() {
		
		return $this->name;
	}
	
	/**
	 * Sets the parameter type.
	 * 
	 * @param string $type The type of the parameter.
	 * @return PHPParameter This object instance to provide a fluent interface.
	 */
	public function setType($type) {
		
		$this->type = $type;
		
		return $this;
	}
	
	/**
	 * Returns the parameter type.
	 * 
	 * @return string The type of the parameter.
	 */
	public function getType() {
		
		return $this->type;
	}
	
	/**
	 * Sets the parameter value.
	 * 
	 * @param PHPValue $value The value of the parameter.
	 * @return PHPParameter This object instance to provide a fluent interface.
	 */
	public function setValue(PHPValue $value) {
		
		$this->value = $value;
		
		return $this;
	}
	
	/**
	 * Returns the parameter value.
	 * 
	 * @return PHPValue The value of the parameter.
	 */
	public function getValue() {
		
		return $this->value;
	}
	
	/**
	 * Generate the parameter and return it.
	 * 
	 * @return string The generated parameter.
	 */
	public function generate() {
		
		$code  = $this->type ? $this->type . ' ' : '';
		$code .= '$' . $this->name;
		$code .= $this->value ? ' = ' . $this->value->generate() : '';
		
		return $code;
	}
}
