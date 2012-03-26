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

use com\mohiva\manitou\Config;

/**
 * Unit test case for the Mohiva Manitou project.
 *
 * @category  Mohiva/Manitou
 * @package   Mohiva/Manitou/Test
 * @author    Christian Kaps <christian.kaps@mohiva.com>
 * @copyright Copyright (c) 2007-2012 Christian Kaps (http://www.mohiva.com)
 * @license   https://github.com/mohiva/manitou/blob/master/LICENSE.textile New BSD License
 * @link      https://github.com/mohiva/manitou
 */
class ConfigTest extends \PHPUnit_Framework_TestCase {

	/**
	 * Test the `setLineFeed` and `getLineFeed` methods.
	 */
	public function testLineFeedAccessors() {

		$value = sha1(microtime(true));

		$config = new Config;
		$config->setNewline($value);

		$this->assertEquals($value, $config->getNewline());
	}

	/**
	 * Test the `setIndentString` and `getIndentString` methods.
	 */
	public function testIndentStringAccessors() {

		$value = sha1(microtime(true));

		$config = new Config;
		$config->setIndentString($value);

		$this->assertEquals($value, $config->getIndentString());
	}

	/**
	 * Test if the `emptyLinesIndented` method returns true.
	 */
	public function testIfEmptyLinesIntendedReturnsTrue() {

		$config = new Config;
		$config->indentEmptyLines(true);

		$this->assertTrue($config->emptyLinesIndented());
	}

	/**
	 * Test if the `emptyLinesIndented` method returns false.
	 */
	public function testIfEmptyLinesIntendedReturnsFalse() {

		$config = new Config;
		$config->indentEmptyLines(false);

		$this->assertFalse($config->emptyLinesIndented());
	}
}
