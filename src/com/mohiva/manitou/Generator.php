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
 * Abstract generator class.
 *
 * Provides basic functionality for all generator classes.
 *
 * @category  Mohiva/Manitou
 * @package   Mohiva/Manitou
 * @author    Christian Kaps <christian.kaps@mohiva.com>
 * @copyright Copyright (c) 2007-2012 Christian Kaps (http://www.mohiva.com)
 * @license   https://github.com/mohiva/manitou/blob/master/LICENSE.textile New BSD License
 * @link      https://github.com/mohiva/manitou
 */
abstract class Generator {

	/**
	 * The config object for the generator classes.
	 *
	 * @var Config
	 */
	protected static $config = null;

	/**
	 * Sets the config object for the generator classes.
	 *
	 * @param Config $config The config object for the generator classes.
	 */
	public static function setConfig(Config $config) {

		self::$config = $config;
	}

	/**
	 * Gets the config object for the generator classes.
	 *
	 * If no config object was set previously, then this method creates an default config.
	 *
	 * @return Config The config object for the generator classes.
	 */
	public static function getConfig() {

		if (self::$config === null) {
			self::$config = new Config();
		}

		return self::$config;
	}

	/**
	 * Wrapper for the `generate()` method.
	 *
	 * @return string The generated string.
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
	 * Indent the given content with the indent string defined in the config object.
	 *
	 * @param string $content The content to indent.
	 * @param int $level The indention level. 0 for no indention, 1 for the first level, 2 for the second and so one.
	 * @return string The indented content.
	 */
	public function indent($content, $level = 1) {

		if ($level == 0) {
			return $content;
		}

		$config = self::getConfig();
		$indentation = str_repeat($config->getIndentString(), $level);

		$emptyLinePattern = $config->emptyLinesIndented() ? '*' : '+';
		$pattern = "/([^\r\n]" . $emptyLinePattern . ")/";
		$content = preg_replace($pattern, $indentation . '$1', $content);

		return $content;
	}
}
