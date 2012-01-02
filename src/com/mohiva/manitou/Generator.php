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
namespace com\mohiva\manitou;

/**
 * Abstract generator class.
 * 
 * Provides basic functionality for all generator classes.
 * 
 * @category  Mohiva/Manitou
 * @package   Mohiva/Manitou/Exceptions
 * @author    Christian Kaps <christian.kaps@mohiva.com>
 * @copyright Copyright (c) 2007-2012 Christian Kaps (http://www.mohiva.com)
 * @license   https://github.com/mohiva/manitou/blob/master/LICENSE.textile New BSD License
 * @link      https://github.com/mohiva/manitou
 */
abstract class Generator {
	
	/**
	 * The line feed control character.
	 * 
	 * @var string
	 */
	const LINE_FEED = PHP_EOL;
	
	/**
	 * The indentation string for all code generator classes.
	 * 
	 * @var string
	 */
	protected static $indentString = "\t";
	
	/**
	 * Sets the string which should be used for indentation.
	 * 
	 * @param string $indentString The string which should be used for indentation.
	 */
	public static function setIndentString($indentString) {
		
		self::$indentString = $indentString;
	}
	
	/**
	 * Gets the string which is used for indentation.
	 * 
	 * @return int The string which is used for indentation.
	 */
	public static function getIndentString() {
		
		return self::$indentString;
	}
	
	/**
	 * Wrapper for the `generate()` method.
	 * 
	 * @return The generated string.
	 */
	public function __toString() {
		
		return $this->generate();
	}
	
	/**
	 * Generates the content of the code fragment and return it.
	 * 
	 * @return string The generated content.
	 */
	abstract public function generate();
	
	/**
	 * Indent the given content by the current indentation value.
	 * 
	 * @param string $content The content to indent.
	 * @return string The indented content.
	 */
	protected function indent($content) {
		
		$indentation = self::getIndentString();
		$pattern = '/([^' . self::LINE_FEED . ']*' . self::LINE_FEED . ')/';
		$content = preg_replace($pattern, $indentation . '$1', $content);
		
		return $content;
	}
}
