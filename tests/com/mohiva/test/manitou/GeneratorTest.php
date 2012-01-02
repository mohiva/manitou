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
 * Unit test case for the Mohiva `Generator` class.
 * 
 * @category  Mohiva/Manitou
 * @package   Mohiva/Manitou/Test
 * @author    Christian Kaps <christian.kaps@mohiva.com>
 * @copyright Copyright (c) 2007-2012 Christian Kaps (http://www.mohiva.com)
 * @license   https://github.com/mohiva/manitou/blob/master/LICENSE.textile New BSD License
 * @link      https://github.com/mohiva/manitou
 */
class GeneratorTest extends \PHPUnit_Framework_TestCase {
	
	/**
	 * Setup the test case.
	 */
	public function setUp() {
		
		Generator::setIndentString("\t");
	}
	
	/**
	 * Tear down the test case.
	 */
	public function tearDown() {
		
		Generator::setIndentString("\t");
	}
	
	/**
	 * Test if can set and get the indentation.
	 */
	public function testIndentStringAccessors() {
		
		Generator::setIndentString('    ');
		
		$this->assertEquals('    ', Generator::getIndentString());
	}
}
