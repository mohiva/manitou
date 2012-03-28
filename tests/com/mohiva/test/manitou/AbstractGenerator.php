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
 * @package   Mohiva/Manitou/Test
 * @author    Christian Kaps <christian.kaps@mohiva.com>
 * @copyright Copyright (c) 2007-2012 Christian Kaps (http://www.mohiva.com)
 * @license   https://github.com/mohiva/manitou/blob/master/LICENSE.textile New BSD License
 * @link      https://github.com/mohiva/manitou
 */
namespace com\mohiva\test\manitou;

use com\mohiva\manitou\Generator;

/**
 * Abstract unit test case for the Mohiva php code generator classes.
 *
 * @category  Mohiva/Manitou
 * @package   Mohiva/Manitou/Test
 * @author    Christian Kaps <christian.kaps@mohiva.com>
 * @copyright Copyright (c) 2007-2012 Christian Kaps (http://www.mohiva.com)
 * @license   https://github.com/mohiva/manitou/blob/master/LICENSE.textile New BSD License
 * @link      https://github.com/mohiva/manitou
 */
abstract class AbstractGenerator extends \PHPUnit_Framework_TestCase {

	/**
	 * Get the content from the given file and replace all line endings with the
	 * current `Generator::LINE_FEED` character.
	 *
	 * @param string $file The name of the file to load.
	 * @return string The content of the file with the current line ending.
	 */
	protected function getFileContent($file) {

		$content = file_get_contents($file);
		$content = preg_replace('/\r\n|\r|\n/', Generator::getConfig()->getNewline(), $content);

		return $content;
	}
}
