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
 * Generates the source code for a use statement.
 *
 * @category  Mohiva/Manitou
 * @package   Mohiva/Manitou/Generators
 * @author    Christian Kaps <christian.kaps@mohiva.com>
 * @copyright Copyright (c) 2007-2012 Christian Kaps (http://www.mohiva.com)
 * @license   https://github.com/mohiva/manitou/blob/master/LICENSE.textile New BSD License
 * @link      https://github.com/mohiva/manitou
 */
class PHPUse extends Generator {

	/**
	 * A fully qualified class or namespace name.
	 *
	 * @var string
	 */
	private $fqn = null;

	/**
	 * An alias for the fully qualified class or namespace name.
	 *
	 * @var string
	 */
	private $alias = null;

	/**
	 * The class constructor.
	 *
	 * @param string $fqn A fully qualified class or namespace name.
	 * @param string $alias An alias for the fully qualified class or namespace name.
	 */
	public function __construct($fqn, $alias = null) {

		$this->alias = $alias;
		$this->setFQN($fqn);
	}

	/**
	 * Sets a the class or namespace name.
	 *
	 * @param string $fqn A fully qualified class or namespace name.
	 * @return PHPUse This object instance to provide a fluent interface.
	 */
	public function setFQN($fqn) {

		$this->fqn = trim($fqn, '\\');

		return $this;
	}

	/**
	 * Gets the class or namespace name.
	 *
	 * @return string A fully qualified class or namespace name.
	 */
	public function getFQN() {

		return $this->fqn;
	}

	/**
	 * Sets the alias for the class or namespace name.
	 *
	 * @param string $alias An alias for the fully qualified class or namespace name.
	 * @return PHPUse This object instance to provide a fluent interface.
	 */
	public function setAlias($alias) {

		$this->alias = $alias;

		return $this;
	}

	/**
	 * Gets the alias for the class or namespace name.
	 *
	 * @return string An alias for the fully qualified class or namespace name.
	 */
	public function getAlias() {

		return $this->alias;
	}

	/**
	 * Generate the use statement and return it.
	 *
	 * @return string The generated use statement.
	 */
	public function generate() {

		$lineFeed = self::getConfig()->getNewline();
		$code  = 'use ' . $this->fqn;
		$code .= $this->alias ? ' as ' . $this->alias : '';
		$code .= ';' . $lineFeed;

		return $code;
	}
}
