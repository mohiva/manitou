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
namespace com\mohiva\test\manitou\generators\php;

use com\mohiva\test\manitou\Bootstrap;
use com\mohiva\test\manitou\AbstractGenerator;
use com\mohiva\manitou\generators\php\PHPUse;

/**
 * Unit test case for the `PHPUse` class.
 * 
 * @category  Mohiva/Manitou
 * @package   Mohiva/Manitou/Test
 * @author    Christian Kaps <christian.kaps@mohiva.com>
 * @copyright Copyright (c) 2007-2012 Christian Kaps (http://www.mohiva.com)
 * @license   https://github.com/mohiva/manitou/blob/master/LICENSE.textile New BSD License
 * @link      https://github.com/mohiva/manitou
 */
class PHPUseTest extends AbstractGenerator {
	
	/**
	 * Test if can set or get the fully qualified class or namespace name.
	 */
	public function testFQNAccessors() {
		
		$use = new PHPUse('\com\mohiva\test1');
		
		$this->assertSame('com\mohiva\test1', $use->getFQN());
		
		$use->setFQN('\com\mohiva\test2');
		
		$this->assertSame('com\mohiva\test2', $use->getFQN());
	}
	
	/**
	 * Test if can set or get the alias for a fully qualified class or namespace name.
	 */
	public function testAliasAccessors() {
		
		$use = new PHPUse('\com\mohiva\test');
		$use->setAlias('MyAlias');
		
		$this->assertSame('MyAlias', $use->getAlias());
	}
	
	/**
	 * Test if can generate a use statement without an alias.
	 */
	public function testGenerateUseWithoutAlias() {
		
		$file = Bootstrap::$resourceDir . '/manitou/generators/php/use.txt';
		$expected = $this->getFileContent($file);
		
		$use = new PHPUse('\com\mohiva\test');
		
		$this->assertEquals($expected, $use->generate());
	}
	
	/**
	 * Test if can generate a use statement without an alias.
	 */
	public function testGenerateUseWithAlias() {
		
		$file = Bootstrap::$resourceDir . '/manitou/generators/php/use_alias.txt';
		$expected = $this->getFileContent($file);
		
		$use = new PHPUse('\com\mohiva\test', 'MyAlias');
		
		$this->assertEquals($expected, $use->generate());
	}
}
