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

use UnexpectedValueException;
use com\mohiva\manitou\Generator;

/**
 * Generates a PHP value.
 *
 * @category  Mohiva/Manitou
 * @package   Mohiva/Manitou/Exceptions
 * @author    Christian Kaps <christian.kaps@mohiva.com>
 * @copyright Copyright (c) 2007-2012 Christian Kaps (http://www.mohiva.com)
 * @license   https://github.com/mohiva/manitou/blob/master/LICENSE.textile New BSD License
 * @link      https://github.com/mohiva/manitou
 */
class PHPValue extends Generator {

	/**
	 * The value types.
	 *
	 * @var string
	 */
	const TYPE_AUTO     = 'auto';
	const TYPE_BOOLEAN  = 'boolean';
	const TYPE_NUMBER   = 'number';
	const TYPE_INTEGER  = 'integer';
	const TYPE_FLOAT    = 'float';
	const TYPE_STRING   = 'string';
	const TYPE_ARRAY    = 'array';
	const TYPE_CONSTANT = 'constant';
	const TYPE_NULL     = 'null';
	const TYPE_RAW      = 'raw';
	const TYPE_OTHER    = 'other';

	/**
	 * The array output modes.
	 *
	 * @var int
	 */
	const OUTPUT_SINGLE_LINE = 1;
	const OUTPUT_MULTI_LINE  = 2;

	/**
	 * The value.
	 *
	 * @var mixed
	 */
	protected $value = null;

	/**
	 * The type of the value.
	 *
	 * @var string
	 */
	protected $type = self::TYPE_AUTO;

	/**
	 * Indicates if a array declaration should be written on a
	 * single line or on multiple lines.
	 *
	 * @var int
	 */
	protected $arrayOutput = self::OUTPUT_MULTI_LINE;

	/**
	 * Create an instance of this class and return it. This method
	 * exists to provide a fluent interface.
	 *
	 * @param mixed $value The value.
	 * @return PHPValue An instance of this class.
	 */
	public static function create($value) {

		$instance = new self($value);

		return $instance;
	}

	/**
	 * The class constructor.
	 *
	 * @param mixed $value The value.
	 * @param string $type The type of the value.
	 */
	public function __construct($value, $type = self::TYPE_AUTO) {

		$this->value = $value;
		$this->type = $type;
	}

	/**
	 * Sets the value.
	 *
	 * @param mixed $value The value.
	 * @return PHPValue This object instance to provide a fluent interface.
	 */
	public function setValue($value) {

		$this->value = $value;

		return $this;
	}

	/**
	 * Gets the value.
	 *
	 * @return mixed The value.
	 */
	public function getValue() {

		return $this->value;
	}

	/**
	 * Sets the value type.
	 *
	 * @param mixed $type The type of the value.
	 * @return PHPValue This object instance to provide a fluent interface.
	 */
	public function setType($type) {

		$this->type = $type;

		return $this;
	}

	/**
	 * Gets the value type.
	 *
	 * @return mixed The type of the value.
	 */
	public function getType() {

		return $this->type;
	}

	/**
	 * Sets the array output mode.
	 *
	 * @param int $outputMode The value of one of the `OUTPUT_*` class constants.
	 * @return PHPValue This object instance to provide a fluent interface.
	 * @throws UnexpectedValueException if an unexpected output mode is given.
	 */
	public function setArrayOutput($outputMode) {

		if ($outputMode != self::OUTPUT_MULTI_LINE && $outputMode != self::OUTPUT_SINGLE_LINE) {
			throw new UnexpectedValueException("Wrong output value `{$outputMode}` given, allowed values are 1 and 2");
		}

		$this->arrayOutput = $outputMode;

		return $this;
	}

	/**
	 * Gets the array output mode.
	 *
	 * @return int The value of one of the `OUTPUT_*` class constants.
	 */
	public function getArrayOutput() {

		return $this->arrayOutput;
	}

	/**
	 * Generate a PHP value and return it.
	 *
	 * @return string The generated PHP value.
	 * @throws UnexpectedValueException if an unexpected type for the value is given.
	 */
	public function generate() {

		if ($this->type == self::TYPE_AUTO) {
			$type = $this->autoDiscoverType($this->value);
		} else {
			$type = $this->type;
		}

		$code = '';
		switch ($type) {
			case self::TYPE_BOOLEAN:
				$code .= ($this->value ? 'true' : 'false');
				break;

			case self::TYPE_NUMBER:
			case self::TYPE_INTEGER:
			case self::TYPE_FLOAT:
			case self::TYPE_CONSTANT:
			case self::TYPE_RAW:
				$code .= $this->value;
				break;

			case self::TYPE_STRING:
				$code .= "'" . addcslashes($this->value, "'") . "'";
				break;

			case self::TYPE_ARRAY:
				$code .= $this->generateArray($this->value);
				break;

			case self::TYPE_NULL:
				$code .= 'null';
				break;

			default:
				throw new UnexpectedValueException("The type `{$type}` cannot be used to generate a value");
		}

		return $code;
	}

	/**
	 * Generate the code for the given array.
	 *
	 * @param mixed $data The data to export.
	 * @param int $level The indentation level.
	 * @return string The string representation of the given array.
	 */
	protected function generateArray($data, $level = 1) {

		$code = '';
		$config = self::getConfig();
		$lineFeed = $config->getNewline();
		$indent = $config->getIndentString();
		if (is_bool($data)) {
			$code .= $data ? 'true' : 'false';
		} else if (is_string($data)) {
			$code .= "'" . addcslashes($data, "'") . "'";
		} else if (is_float($data) || is_int($data)) {
			$code .= $data;
		} else if (is_null($data)) {
			$code .= 'null';
		} else if (is_resource($data)) {
			$code .= 'resource';
		} else if (is_object($data)) {
			$ref = new \ReflectionObject($data);
			$props = $ref->getProperties();
			$propsArray = array();
			foreach ($props as $prop) {
				$prop->setAccessible(true);
				$propsArray[$prop->getName()] = $prop->getValue($data);
			}
			$code .= $ref->getName() . '::__set_state(';
			$code .= $this->generateArray($propsArray, $level);
			$code .= ")";
		} else if (is_array($data)) {
			$singleLine = $this->arrayOutput == self::OUTPUT_SINGLE_LINE || empty($data);
			$i = 0;
			$cnt = count($data);
			$code .= 'array(' . ($singleLine ? '' : $lineFeed);
			foreach ($data as $key => $value) {
				$key = is_string($key) ? "'" . addcslashes($key, "'") . "'" : $key;
				$val = $this->generateArray($value, $level + 1);
				if ($singleLine) {
					$code .= $key . ' => ' . $val . (++$i == $cnt ? '' : ', ');
				} else {
					$code .= str_repeat($indent, $level);
					$code .= $key . ' => ' . $val . (++$i == $cnt ? '' : ',') . $lineFeed;
				}
			}

			$code .= str_repeat($indent, $level - 1);
			$code .= ")";
		}

		return $code;
	}

	/**
	 * Discover the type for the given value.
	 *
	 * @param mixed $value The value.
	 * @return string The type of the value.
	 */
	protected function autoDiscoverType($value) {

		if (is_bool($value)) {
			return self::TYPE_BOOLEAN;
		} else if (is_string($value)) {
			return self::TYPE_STRING;
		} else if (is_float($value)) {
			return self::TYPE_FLOAT;
		} else if (is_int($value)) {
			return self::TYPE_INTEGER;
		} else if (is_array($value)) {
			return self::TYPE_ARRAY;
		} else if (is_null($value)) {
			return self::TYPE_NULL;
		} else {
			return self::TYPE_OTHER;
		}
	}
}
