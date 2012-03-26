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
 * @package   Mohiva/Manitou
 * @author    Christian Kaps <christian.kaps@mohiva.com>
 * @copyright Copyright (c) 2007-2012 Christian Kaps (http://www.mohiva.com)
 * @license   https://github.com/mohiva/manitou/blob/master/LICENSE.textile New BSD License
 * @link      https://github.com/mohiva/manitou
 */
namespace com\mohiva\manitou;

/**
 * Config object for the generator classes.
 *
 * @category  Mohiva/Manitou
 * @package   Mohiva/Manitou
 * @author    Christian Kaps <christian.kaps@mohiva.com>
 * @copyright Copyright (c) 2007-2012 Christian Kaps (http://www.mohiva.com)
 * @license   https://github.com/mohiva/manitou/blob/master/LICENSE.textile New BSD License
 * @link      https://github.com/mohiva/manitou
 */
class Config {

	/**
	 * The newline character.
	 *
	 * @var string
	 */
	private $newline = PHP_EOL;

	/**
	 * The indentation string used to indent lines.
	 *
	 * @var string
	 */
	private $indentString = "\t";

	/**
	 * Indicates if empty lines should be indented or not.
	 *
	 * @var bool
	 */
	private $indentEmptyLines = false;

	/**
	 * Gets the newline character.
	 *
	 * @param string $newline The newline character.
	 */
	public function setNewline($newline) {

		$this->newline = $newline;
	}

	/**
	 * Gets the newline character.
	 *
	 * @return string The newline character.
	 */
	public function getNewline() {

		return $this->newline;
	}

	/**
	 * Sets the string which should be used for indentation.
	 *
	 * @param string $indentString The string which should be used for indentation.
	 */
	public function setIndentString($indentString) {

		$this->indentString = $indentString;
	}

	/**
	 * Gets the string which is used for indentation.
	 *
	 * @return int The string which is used for indentation.
	 */
	public function getIndentString() {

		return $this->indentString;
	}

	/**
	 * Set if empty lines should be indented or not.
	 *
	 * @param bool $value True if empty lines should be indented, false otherwise.
	 */
	public function indentEmptyLines($value) {

		$this->indentEmptyLines = $value;
	}

	/**
	 * Gets if empty lines should be intended or not.
	 *
	 * @return bool True if empty lines should be indented, false otherwise.
	 */
	public function emptyLinesIndented() {

		return $this->indentEmptyLines;
	}
}
