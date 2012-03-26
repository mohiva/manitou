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
use com\mohiva\manitou\generators\php\PHPParameter;
use com\mohiva\manitou\generators\php\PHPValue;

/**
 * Unit test case for the `PHPParameter` class.
 *
 * @category  Mohiva/Manitou
 * @package   Mohiva/Manitou/Test
 * @author    Christian Kaps <christian.kaps@mohiva.com>
 * @copyright Copyright (c) 2007-2012 Christian Kaps (http://www.mohiva.com)
 * @license   https://github.com/mohiva/manitou/blob/master/LICENSE.textile New BSD License
 * @link      https://github.com/mohiva/manitou
 */
class PHPParameterTest extends AbstractGenerator {

	/**
	 * Test if can set or get the name of a parameter.
	 */
	public function testNameAccessors() {

		$parameter = new PHPParameter('name');

		$this->assertSame('name', $parameter->getName());

		$parameter->setName('value');

		$this->assertSame('value', $parameter->getName());
	}

	/**
	 * Test if can set or get the type of a parameter.
	 */
	public function testTypeAccessors() {

		$parameter = new PHPParameter('name', 'int');

		$this->assertSame('int', $parameter->getType());

		$parameter->setType('PHPValue');

		$this->assertSame('PHPValue', $parameter->getType());
	}

	/**
	 * Test if can set or get the value of a parameter.
	 */
	public function testValueAccessors() {

		$value1 = new PHPValue(1);
		$value2 = new PHPValue(2);

		$parameter = new PHPParameter('index', 'int', $value1);

		$this->assertSame($value1, $parameter->getValue());

		$parameter->setValue($value2);

		$this->assertSame($value2, $parameter->getValue());
	}

	/**
	 * Test if can generate a parameter.
	 */
	public function testGenerateParameter() {

		$file = Bootstrap::$resourceDir . '/manitou/generators/php/parameter.txt';
		$expected = $this->getFileContent($file);

		$parameter = new PHPParameter('index');

		$this->assertEquals($expected, $parameter->generate());
	}

	/**
	 * Test if can generate a parameter with a type.
	 */
	public function testGenerateParameterWithType() {

		$file = Bootstrap::$resourceDir . '/manitou/generators/php/parameter_type.txt';
		$expected = $this->getFileContent($file);

		$parameter = new PHPParameter('index', 'int');

		$this->assertEquals($expected, $parameter->generate());
	}

	/**
	 * Test if can generate a parameter with a value.
	 */
	public function testGenerateParameterWithValue() {

		$file = Bootstrap::$resourceDir . '/manitou/generators/php/parameter_value.txt';
		$expected = $this->getFileContent($file);

		$parameter = new PHPParameter('index', null, new PHPValue(1));

		$this->assertEquals($expected, $parameter->generate());
	}

	/**
	 * Test if can generate a parameter with a type and a value.
	 */
	public function testGenerateParameterWithTypeAndValue() {

		$file = Bootstrap::$resourceDir . '/manitou/generators/php/parameter_type_value.txt';
		$expected = $this->getFileContent($file);

		$parameter = new PHPParameter('index', 'int', new PHPValue(1));

		$this->assertEquals($expected, $parameter->generate());
	}
}
