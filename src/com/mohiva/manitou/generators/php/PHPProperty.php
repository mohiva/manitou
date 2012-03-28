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
 * Generates the source code for a property.
 *
 * @category  Mohiva/Manitou
 * @package   Mohiva/Manitou/Generators
 * @author    Christian Kaps <christian.kaps@mohiva.com>
 * @copyright Copyright (c) 2007-2012 Christian Kaps (http://www.mohiva.com)
 * @license   https://github.com/mohiva/manitou/blob/master/LICENSE.textile New BSD License
 * @link      https://github.com/mohiva/manitou
 */
class PHPProperty extends PHPMember {

	/**
	 * The value of the property.
	 *
	 * @var PHPValue
	 */
	private $value = null;

	/**
	 * The class constructor.
	 *
	 * @param string $name The name of the property.
	 * @param PHPValue $value The value of the constant.
	 * @param int $visibility On of the predefined `VISIBILITY_*` constants.
	 * @param boolean $isStatic True if the property is static, false otherwise.
	 */
	public function __construct(
		$name,
		PHPValue $value = null,
		$visibility = self::VISIBILITY_PROTECTED,
		$isStatic = false) {

		$this->name = $name;
		$this->value = $value;
		$this->visibility = $visibility;
		$this->isStatic = $isStatic;
	}

	/**
	 * Sets the property value,
	 *
	 * @param PHPValue $value The value of the property.
	 * @return PHPProperty This object instance to provide a fluent interface.
	 */
	public function setValue(PHPValue $value) {

		$this->value = $value;

		return $this;
	}

	/**
	 * Gets the property value.
	 *
	 * @return PHPValue The value of the property.
	 */
	public function getValue() {

		return $this->value;
	}

	/**
	 * Generate the property and return it.
	 *
	 * @return string The generated property.
	 */
	public function generate() {

		$visibility = $this->getVisibilityKeyword();

		$lineFeed = self::getConfig()->getNewline();
		$code  = $this->generateDocBlock();
		$code .= $visibility . ' ';
		$code .= $this->isStatic ? 'static ' : '';
		$code .= '$' . $this->name;
		$code .= $this->value ? " = " . $this->value->generate() : '';
		$code .= ';' . $lineFeed;

		return $code;
	}
}
