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
use com\mohiva\manitou\exceptions\UnexpectedVisibilityException;

/**
 * Abstract class for all class or interface members.
 *
 * @category  Mohiva/Manitou
 * @package   Mohiva/Manitou/Generators
 * @author    Christian Kaps <christian.kaps@mohiva.com>
 * @copyright Copyright (c) 2007-2012 Christian Kaps (http://www.mohiva.com)
 * @license   https://github.com/mohiva/manitou/blob/master/LICENSE.textile New BSD License
 * @link      https://github.com/mohiva/manitou
 */
abstract class PHPMember extends Generator {

	/**
	 * Member visibility.
	 *
	 * @var int
	 */
	const VISIBILITY_PUBLIC    = 1;
	const VISIBILITY_PROTECTED = 2;
	const VISIBILITY_PRIVATE   = 3;

	/**
	 * The name of the member.
	 *
	 * @var string
	 */
	protected $name = null;

	/**
	 * The visibility of the member.
	 *
	 * @var int
	 */
	protected $visibility = self::VISIBILITY_PUBLIC;

	/**
	 * Indicates if the member is static or not.
	 *
	 * @var boolean
	 */
	protected $isStatic = false;

	/**
	 * The member DocBlock.
	 *
	 * @var PHPDocBlock
	 */
	protected $docBlock = null;

	/**
	 * Sets the name of the member.
	 *
	 * @param string $name The name of the member.
	 * @return PHPMember This object instance to provide a fluent interface.
	 */
	public function setName($name) {

		$this->name = $name;

		return $this;
	}

	/**
	 * Gets the name of the member.
	 *
	 * @return string The name of the member.
	 */
	public function getName() {

		return $this->name;
	}

	/**
	 * Sets the visibility of this member.
	 *
	 * @param int $visibility The value of on of the predefined `VISIBILITY_*` constants.
	 * @return PHPMember This object instance to provide a fluent interface.
	 */
	public function setVisibility($visibility) {

		$this->visibility = $visibility;

		return $this;
	}

	/**
	 * Gets the visibility of this member.
	 *
	 * @return int The value of on of the predefined `VISIBILITY_*` constants.
	 */
	public function getVisibility() {

		return $this->visibility;
	}

	/**
	 * Defines if the member is final or not.
	 *
	 * @param boolean $isStatic True if the member is static, false otherwise.
	 * @return PHPMember This object instance to provide a fluent interface.
	 */
	public function setStatic($isStatic) {

		$this->isStatic = $isStatic;

		return $this;
	}

	/**
	 * Indicates if the member is static or not.
	 *
	 * @return boolean True if the member is static, false otherwise.
	 */
	public function isStatic() {

		return $this->isStatic;
	}

	/**
	 * Sets the DocBlock object for this member.
	 *
	 * @param PHPDocBlock $docBlock The DocBlock object for this member.
	 * @return PHPMember This object instance to provide a fluent interface.
	 */
	public function setDocBlock(PHPDocBlock $docBlock) {

		$this->docBlock = $docBlock;

		return $this;
	}

	/**
	 * Gets the DocBlock object for this member.
	 *
	 * @return PHPDocBlock The DocBlock object for this member.
	 */
	public function getDocBlock() {

		return $this->docBlock;
	}

	/**
	 * Generate the DocBlock part of this member.
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
	 * Get the keyword for the visibility of the property.
	 *
	 * @return string The visibility keyword for the property.
	 * @throws \com\mohiva\manitou\exceptions\UnexpectedVisibilityException if a wrong visibility was given.
	 */
	protected function getVisibilityKeyword() {

		if ($this->visibility == self::VISIBILITY_PRIVATE) {
			return 'private';
		} else if ($this->visibility == self::VISIBILITY_PROTECTED) {
			return 'protected';
		} else if ($this->visibility == self::VISIBILITY_PUBLIC) {
			return 'public';
		}

		throw new UnexpectedVisibilityException("No visibility constant with the value `{$this->visibility}` defined");
	}
}
