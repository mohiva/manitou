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
use com\mohiva\manitou\generators\php\PHPValue;

/**
 * Unit test case for the `PHPValue` class.
 *
 * @category  Mohiva/Manitou
 * @package   Mohiva/Manitou/Test
 * @author    Christian Kaps <christian.kaps@mohiva.com>
 * @copyright Copyright (c) 2007-2012 Christian Kaps (http://www.mohiva.com)
 * @license   https://github.com/mohiva/manitou/blob/master/LICENSE.textile New BSD License
 * @link      https://github.com/mohiva/manitou
 */
class PHPValueTest extends AbstractGenerator {

	/**
	 * Test if can set or get the name of a class.
	 */
	public function testValueAccessors() {

		$value = new PHPValue(1);

		$this->assertSame(1, $value->getValue());

		$value->setValue('value');

		$this->assertSame('value', $value->getValue());
	}

	/**
	 * Test if can set or get the inherited class.
	 */
	public function testTypeAccessors() {

		$value = new PHPValue(1, PHPValue::TYPE_NUMBER);

		$this->assertSame(PHPValue::TYPE_NUMBER, $value->getType());

		$value->setType(PHPValue::TYPE_BOOLEAN);

		$this->assertSame(PHPValue::TYPE_BOOLEAN, $value->getType());
	}

	/**
	 * Test if can set or get the array output method.
	 */
	public function testArrayOutputAccessors() {

		$value = new PHPValue(array(1));
		$value->setArrayOutput(PHPValue::OUTPUT_MULTI_LINE);

		$this->assertSame(PHPValue::OUTPUT_MULTI_LINE, $value->getArrayOutput());

		$value->setArrayOutput(PHPValue::OUTPUT_SINGLE_LINE);

		$this->assertSame(PHPValue::OUTPUT_SINGLE_LINE, $value->getArrayOutput());
	}

	/**
	 * Test if the value type will be correct auto discovered.
	 */
	public function testAutoType() {

		$val1 = new PHPValue(1);
		$val2 = new PHPValue(1.1);
		$val3 = new PHPValue(true);
		$val4 = new PHPValue(false);
		$val5 = new PHPValue(null);
		$val6 = new PHPValue('value');
		$val7 = new PHPValue(array(1));
		$val7->setArrayOutput(PHPValue::OUTPUT_SINGLE_LINE);

		$this->assertSame('1', $val1->generate());
		$this->assertSame('1.1', $val2->generate());
		$this->assertSame('true', $val3->generate());
		$this->assertSame('false', $val4->generate());
		$this->assertSame('null', $val5->generate());
		$this->assertSame("'value'", $val6->generate());
		$this->assertSame("array(0 => 1)", $val7->generate());
	}

	/**
	 * Test if can generate a numeric value.
	 */
	public function testGenerateNumber() {

		$value = new PHPValue(1, PHPValue::TYPE_NUMBER);
		$this->assertSame('1', $value->generate());
	}

	/**
	 * Test if can generate a int value.
	 */
	public function testGenerateInt() {

		$value = new PHPValue(1, PHPValue::TYPE_INTEGER);
		$this->assertSame('1', $value->generate());
	}

	/**
	 * Test if can generate a float value.
	 */
	public function testGenerateFloat() {

		$value = new PHPValue(1.1, PHPValue::TYPE_FLOAT);
		$this->assertSame('1.1', $value->generate());
	}

	/**
	 * Test if can generate boolean value.
	 */
	public function testGenerateBoolean() {

		$value = new PHPValue(true, PHPValue::TYPE_BOOLEAN);
		$this->assertSame('true', $value->generate());

		$value = new PHPValue(false, PHPValue::TYPE_BOOLEAN);
		$this->assertSame('false', $value->generate());
	}

	/**
	 * Test if can generate null.
	 */
	public function testGenerateNull() {

		$value = new PHPValue(1.1, PHPValue::TYPE_NULL);
		$this->assertSame('null', $value->generate());
	}

	/**
	 * Test if can generate a string value.
	 */
	public function testGenerateString() {

		$value = new PHPValue('value', PHPValue::TYPE_STRING);
		$this->assertSame("'value'", $value->generate());
	}

	/**
	 * Test if can generate a constant.
	 */
	public function testGenerateConstant() {

		$value = new PHPValue('TYPE_CONSTANT', PHPValue::TYPE_CONSTANT);
		$this->assertSame('TYPE_CONSTANT', $value->generate());
	}

	/**
	 * Test if can generate a raw value.
	 */
	public function testGenerateRaw() {

		$value = new PHPValue("'a raw 'string'", PHPValue::TYPE_RAW);
		$this->assertSame("'a raw 'string'", $value->generate());
	}

	/**
	 * Test if can generate a single line array.
	 */
	public function testGenerateSingleLineArray() {

		$file = Bootstrap::$resourceDir . '/manitou/generators/php/value_array_single_line.txt';
		$expected = $this->getFileContent($file);

		$value = new PHPValue(array(1, 2, "te\"st" => 3), PHPValue::TYPE_ARRAY);
		$value->setArrayOutput(PHPValue::OUTPUT_SINGLE_LINE);

		$this->assertSame($expected, $value->generate());
	}

	/**
	 * Test if can generate a single line array.
	 */
	public function testGenerateMutliLineArray() {

		$obj1 = new \stdClass();
		$obj1->test = 'test';
		$obj2 = new \stdClass();
		$obj2->single = 1;
		$obj2->mutli = 2;
		$obj2->array = array(
			$obj1
		);
		$array = array(
			1,
			2,
			3,
			array(1 => 1, 2 => 2),
			array($obj2),
			array(array(1, 2, 'test'), array(true, false, null))
		);

		$file = Bootstrap::$resourceDir . '/manitou/generators/php/value_array_multi_line.txt';
		$expected = $this->getFileContent($file);

		$value = new PHPValue($array, PHPValue::TYPE_ARRAY);
		$value->setArrayOutput(PHPValue::OUTPUT_MULTI_LINE);

		$this->assertSame($expected, $value->generate());
	}

	/**
	 * Test if throws an exception if the output type is unexpected.
	 *
	 * @expectedException \UnexpectedValueException
	 */
	public function testExceptionForUnexpectedArrayOutputType() {

		$value = new PHPValue(1);
		$value->setArrayOutput(3);
	}

	/**
	 * Test if throws an exception if the `PHPValue::TYPE_OTHER` type is used.
	 *
	 * @expectedException \UnexpectedValueException
	 */
	public function testExceptionForOtherType() {

		$value = new PHPValue(1, PHPValue::TYPE_OTHER);
		$value->generate();
	}

	/**
	 * Test if throws an exception if the value cannot be auto discovered.
	 *
	 * @expectedException \UnexpectedValueException
	 */
	public function testExceptionForTypeAutoDiscovering() {

		$value = new PHPValue(new \stdClass());
		$value->generate();
	}
}
