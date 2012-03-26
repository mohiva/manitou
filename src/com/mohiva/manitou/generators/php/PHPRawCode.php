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
 * Generates raw PHP code.
 *
 * @category  Mohiva/Manitou
 * @package   Mohiva/Manitou/Exceptions
 * @author    Christian Kaps <christian.kaps@mohiva.com>
 * @copyright Copyright (c) 2007-2012 Christian Kaps (http://www.mohiva.com)
 * @license   https://github.com/mohiva/manitou/blob/master/LICENSE.textile New BSD License
 * @link      https://github.com/mohiva/manitou
 */
class PHPRawCode extends Generator {

	/**
	 * The raw PHP code.
	 *
	 * @var string
	 */
	protected $code = '';

	/**
	 * The default indent level.
	 *
	 * @var int
	 */
	protected $indentLevel = 0;

	/**
	 * Sets the raw PHP code.
	 *
	 * @param string $code The raw PHP code.
	 * @return PHPRawCode This object instance to provide a fluent interface.
	 */
	public function setCode($code) {

		$this->code = $code;

		return $this;
	}

	/**
	 * Gets the raw PHP code.
	 *
	 * @return string The raw PHP code.
	 */
	public function getCode() {

		return $this->code;
	}

	/**
	 * Add a code fragment to the end of the code.
	 *
	 * @param string $code The PHP code fragment to add.
	 * @return PHPRawCode This object instance to provide a fluent interface.
	 */
	public function addCode($code) {

		$this->code .= $code;

		return $this;
	}

	/**
	 * Sets the global indent level.
	 *
	 * @param int $level The global indent level.
	 * @return PHPRawCode This object instance to provide a fluent interface.
	 */
	public function setIndentLevel($level) {

		$this->indentLevel = $level;

		return $this;
	}

	/**
	 * Gets the global indent level.
	 *
	 * @return int The global indent level.
	 */
	public function getIndentLevel() {

		return $this->indentLevel;
	}

	/**
	 * Add a new line with raw PHP code to the existing code.
	 *
	 * If no indention level is given the global level will be used to indent the given string.
	 *
	 * @param string $line The PHP code fragment to add or an empty string for an empty newline.
	 * @param int $level The indention level. 0 for no indention, 1 for the first level, 2 for the second and so one.
	 * @return PHPRawCode This object instance to provide a fluent interface.
	 */
	public function addLine($line = '', $level = 0) {

		$config = self::getConfig();
		$lineFeed = $config->getNewline();

		$level = $level ? $level : $this->indentLevel;
		$this->code .= $this->code ? $lineFeed : '';
		$this->code .= self::indent($line, $level);

		return $this;
	}

	/**
	 * Add the given line to the existing code, and then increment the indent level.
	 *
	 * @param string $line The PHP code fragment to add or an empty string for an empty newline.
	 * @param boolean $closeFirst Indicates if the scope should be closed first before writing a new line.
	 * @return PHPRawCode This object instance to provide a fluent interface.
	 */
	public function openScope($line, $closeFirst = false) {

		if ($closeFirst) $this->indentLevel--;
		$this->addLine($line);
		$this->indentLevel++;

		return $this;
	}

	/**
	 * Decrement the indent level, and then add the given line to the existing code.
	 *
	 * @param string $line The PHP code fragment to add or an empty string for an empty newline.
	 * @param boolean $openAfter Indicates if the scope should be opened after the line was written.
	 * @return PHPRawCode This object instance to provide a fluent interface.
	 */
	public function closeScope($line, $openAfter = false) {

		$this->indentLevel--;
		$this->addLine($line);
		if ($openAfter) $this->indentLevel++;

		return $this;
	}

	/**
	 * Return the raw PHP code.
	 *
	 * @return string The raw PHP code.
	 */
	public function generate() {

		return $this->code;
	}
}
