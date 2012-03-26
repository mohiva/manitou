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
use com\mohiva\manitou\generators\php\PHPConstant;
use com\mohiva\manitou\generators\php\PHPDocBlock;
use com\mohiva\manitou\generators\php\PHPValue;

/**
 * Unit test case for the `PHPConstant` class.
 *
 * @category  Mohiva/Manitou
 * @package   Mohiva/Manitou/Test
 * @author    Christian Kaps <christian.kaps@mohiva.com>
 * @copyright Copyright (c) 2007-2012 Christian Kaps (http://www.mohiva.com)
 * @license   https://github.com/mohiva/manitou/blob/master/LICENSE.textile New BSD License
 * @link      https://github.com/mohiva/manitou
 */
class PHPConstantTest extends AbstractGenerator {

	/**
	 * Test if can set or get the name of a constant.
	 */
	public function testNameAccessors() {

		$constant = new PHPConstant('TEST_CONST1', new PHPValue(1));

		$this->assertSame('TEST_CONST1', $constant->getName());

		$constant->setName('TEST_CONST2');

		$this->assertSame('TEST_CONST2', $constant->getName());
	}

	/**
	 * Test if can set or get the value of a constant.
	 */
	public function testValueAccessors() {

		$value1 = new PHPValue(1);
		$value2 = new PHPValue(2);

		$constant = new PHPConstant('TEST_CONST', $value1);

		$this->assertSame($value1, $constant->getValue());

		$constant->setValue($value2);

		$this->assertSame($value2, $constant->getValue());
	}

	/**
	 * Test if can set or get a DocBlock object.
	 */
	public function testDocBlockAccessors() {

		$constant = new PHPConstant('TEST_CONST', new PHPValue(1));
		$constant->setDocBlock(new PHPDocBlock());

		$this->assertInstanceOf('com\mohiva\manitou\generators\php\PHPDocBlock', $constant->getDocBlock());
	}

	/**
	 * Test if can generate a constant.
	 */
	public function testGenerateConstant() {

		$file = Bootstrap::$resourceDir . '/manitou/generators/php/constant.txt';
		$expected = $this->getFileContent($file);

		$constant = new PHPConstant('TEST_CONST', new PHPValue(4.3, PHPValue::TYPE_STRING));

		$this->assertEquals($expected, $constant->generate());
	}

	/**
	 * Test if can generate a constant with a DocBlock.
	 */
	public function testGenerateConstantWithDocBlock() {

		$file = Bootstrap::$resourceDir . '/manitou/generators/php/constant_docblock.txt';
		$expected = $this->getFileContent($file);

		$constant = new PHPConstant('TEST_CONST', new PHPValue(4.3, PHPValue::TYPE_STRING));
		$constant->setDocBlock(new PHPDocBlock());

		$this->assertEquals($expected, $constant->generate());
	}
}
