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
	 * Test all getters for the values set with the constructor.
	 */
	public function testConstructorAccessors() {

		$name = sha1(microtime(true));
		$type = sha1(microtime(true));
		$value = new PHPValue(1);
		$parameter = new PHPParameter(
			$name,
			$type,
			$value
		);

		$this->assertSame($name, $parameter->getName());
		$this->assertSame($type, $parameter->getType());
		$this->assertSame($value, $parameter->getValue());
	}

	/**
	 * Test the `setName` and `getName` accessors.
	 */
	public function testNameAccessors() {

		$name = sha1(microtime(true));
		$parameter = new PHPParameter('test');
		$parameter->setName($name);

		$this->assertSame($name, $parameter->getName());
	}

	/**
	 * Test the `setType` and `getType` accessors.
	 */
	public function testTypeAccessors() {

		$type = sha1(microtime(true));
		$parameter = new PHPParameter('test');
		$parameter->setType($type);

		$this->assertSame($type, $parameter->getType());
	}

	/**
	 * Test the `setValue` and `getValue` accessors.
	 */
	public function testValueAccessors() {

		$value = new PHPValue(1);

		$parameter = new PHPParameter('test');
		$parameter->setValue($value);

		$this->assertSame($value, $parameter->getValue());
	}

	/**
	 * Test if can generate a parameter.
	 */
	public function testGenerateParameter() {

		$file = Bootstrap::$resourceDir . '/manitou/generators/php/parameter.txt';
		$expected = trim($this->getFileContent($file));

		$parameter = new PHPParameter('index');

		$this->assertEquals($expected, $parameter->generate());
	}

	/**
	 * Test if can generate a parameter with a type.
	 */
	public function testGenerateParameterWithType() {

		$file = Bootstrap::$resourceDir . '/manitou/generators/php/parameter_type.txt';
		$expected = trim($this->getFileContent($file));

		$parameter = new PHPParameter('index', 'int');

		$this->assertEquals($expected, $parameter->generate());
	}

	/**
	 * Test if can generate a parameter with a value.
	 */
	public function testGenerateParameterWithValue() {

		$file = Bootstrap::$resourceDir . '/manitou/generators/php/parameter_value.txt';
		$expected = trim($this->getFileContent($file));

		$parameter = new PHPParameter('index', null, new PHPValue(1));

		$this->assertEquals($expected, $parameter->generate());
	}

	/**
	 * Test if can generate a parameter with a type and a value.
	 */
	public function testGenerateParameterWithTypeAndValue() {

		$file = Bootstrap::$resourceDir . '/manitou/generators/php/parameter_type_value.txt';
		$expected = trim($this->getFileContent($file));

		$parameter = new PHPParameter('index', 'int', new PHPValue(1));

		$this->assertEquals($expected, $parameter->generate());
	}
}
