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

/**
 * Generates the source code for a class or interface member constant in the form:
 * `
 * const CONST_NAME = 'value';
 * `
 *
 * @category  Mohiva/Manitou
 * @package   Mohiva/Manitou/Generators
 * @author    Christian Kaps <christian.kaps@mohiva.com>
 * @copyright Copyright (c) 2007-2012 Christian Kaps (http://www.mohiva.com)
 * @license   https://github.com/mohiva/manitou/blob/master/LICENSE.textile New BSD License
 * @link      https://github.com/mohiva/manitou
 */
class PHPConstant extends Generator {

	/**
	 * The name of the constant.
	 *
	 * @var string
	 */
	private $name = null;

	/**
	 * The value of the constant.
	 *
	 * @var PHPValue
	 */
	private $value = null;

	/**
	 * The constant DocBlock.
	 *
	 * @var PHPDocBlock
	 */
	private $docBlock = null;

	/**
	 * The class constructor.
	 *
	 * @param string $name The name of the constant.
	 * @param PHPValue $value The value of the constant.
	 */
	public function __construct($name, PHPValue $value) {

		$this->name = $name;
		$this->value = $value;
	}

	/**
	 * Sets the name of the constant.
	 *
	 * @param string $name The name of the constant.
	 * @return PHPConstant This object instance to provide a fluent interface.
	 */
	public function setName($name) {

		$this->name = $name;

		return $this;
	}

	/**
	 * Gets the name of the constant.
	 *
	 * @return string The name of the constant.
	 */
	public function getName() {

		return $this->name;
	}

	/**
	 * Sets the value of the constant.
	 *
	 * @param PHPValue $value The value of the constant.
	 * @return PHPConstant This object instance to provide a fluent interface.
	 */
	public function setValue(PHPValue $value) {

		$this->value = $value;

		return $this;
	}

	/**
	 * Gets the value of the constant.
	 *
	 * @return PHPValue The value of the constant.
	 */
	public function getValue() {

		return $this->value;
	}

	/**
	 * Sets the DocBlock object for this constant.
	 *
	 * @param PHPDocBlock $docBlock The DocBlock object for this constant.
	 * @return PHPConstant This object instance to provide a fluent interface.
	 */
	public function setDocBlock(PHPDocBlock $docBlock) {

		$this->docBlock = $docBlock;

		return $this;
	}

	/**
	 * Gets the DocBlock object for this constant.
	 *
	 * @return PHPDocBlock The DocBlock object for this constant.
	 */
	public function getDocBlock() {

		return $this->docBlock;
	}

	/**
	 * Generate a constant declaration and return it.
	 *
	 * @return string The generated constant declaration.
	 */
	public function generate() {

		$lineFeed = self::getConfig()->getNewline();
		$code  = $this->generateDocBlock();
		$code .= "const {$this->name} = {$this->value->generate()};" . $lineFeed;

		return $code;
	}

	/**
	 * Generate the DocBlock part of this constant.
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
}
