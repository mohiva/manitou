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
use com\mohiva\manitou\generators\php\PHPProperty;
use com\mohiva\manitou\generators\php\PHPDocBlock;
use com\mohiva\manitou\generators\php\PHPValue;

/**
 * Unit test case for the `PHPProperty` class.
 *
 * @category  Mohiva/Manitou
 * @package   Mohiva/Manitou/Test
 * @author    Christian Kaps <christian.kaps@mohiva.com>
 * @copyright Copyright (c) 2007-2012 Christian Kaps (http://www.mohiva.com)
 * @license   https://github.com/mohiva/manitou/blob/master/LICENSE.textile New BSD License
 * @link      https://github.com/mohiva/manitou
 */
class PHPPropertyTest extends AbstractGenerator {

	/**
	 * Test if can set or get the name of a property.
	 */
	public function testNameAccessors() {

		$property = new PHPProperty('name');

		$this->assertSame('name', $property->getName());

		$property->setName('value');

		$this->assertSame('value', $property->getName());
	}

	/**
	 * Test if can set or get the value of a property.
	 */
	public function testValueAccessors() {

		$value1 = new PHPValue(1);
		$value2 = new PHPValue(2);

		$property = new PHPProperty('index', $value1);

		$this->assertSame($value1, $property->getValue());

		$property->setValue($value2);

		$this->assertSame($value2, $property->getValue());
	}

	/**
	 * Test if can set or get the visibility of a property.
	 */
	public function testVisibilityAccessors() {

		$property = new PHPProperty('index', new PHPValue(1), PHPProperty::VISIBILITY_PRIVATE);

		$this->assertSame(PHPProperty::VISIBILITY_PRIVATE, $property->getVisibility());

		$property->setVisibility(PHPProperty::VISIBILITY_PROTECTED);

		$this->assertSame(PHPProperty::VISIBILITY_PROTECTED, $property->getVisibility());
	}

	/**
	 * Test if can set or get the static property of a property.
	 */
	public function testIsStaticAccessors() {

		$property = new PHPProperty('index', new PHPValue(1), PHPProperty::VISIBILITY_PRIVATE, true);

		$this->assertTrue($property->isStatic());

		$property->setStatic(false);

		$this->assertFalse($property->isStatic());
	}

	/**
	 * Test if can set or get a DocBlock object.
	 */
	public function testDocBlockAccessors() {

		$property = new PHPProperty('name');
		$property->setDocBlock(new PHPDocBlock());

		$this->assertInstanceOf('com\mohiva\manitou\generators\php\PHPDocBlock', $property->getDocBlock());
	}

	/**
	 * Test if can generate a private property.
	 */
	public function testGeneratePrivateProperty() {

		$file = Bootstrap::$resourceDir . '/manitou/generators/php/property_private.txt';
		$expected = $this->getFileContent($file);

		$property = new PHPProperty('index', null, PHPProperty::VISIBILITY_PRIVATE);

		$this->assertEquals($expected, $property->generate());
	}

	/**
	 * Test if can generate a protected property.
	 */
	public function testGenerateProtectedProperty() {

		$file = Bootstrap::$resourceDir . '/manitou/generators/php/property_protected.txt';
		$expected = $this->getFileContent($file);

		$property = new PHPProperty('index', null, PHPProperty::VISIBILITY_PROTECTED);

		$this->assertEquals($expected, $property->generate());
	}

	/**
	 * Test if can generate a public property.
	 */
	public function testGeneratePublicProperty() {

		$file = Bootstrap::$resourceDir . '/manitou/generators/php/property_public.txt';
		$expected = $this->getFileContent($file);

		$property = new PHPProperty('index', null, PHPProperty::VISIBILITY_PUBLIC);

		$this->assertEquals($expected, $property->generate());
	}

	/**
	 * Test if can generate a property with a value.
	 */
	public function testGeneratePropertyWithValue() {

		$file = Bootstrap::$resourceDir . '/manitou/generators/php/property_value.txt';
		$expected = $this->getFileContent($file);

		$property = new PHPProperty('index', new PHPValue(1));

		$this->assertEquals($expected, $property->generate());
	}

	/**
	 * Test if can generate a static property.
	 */
	public function testGenerateStaticProperty() {

		$file = Bootstrap::$resourceDir . '/manitou/generators/php/property_static.txt';
		$expected = $this->getFileContent($file);

		$property = new PHPProperty('index');
		$property->setStatic(true);

		$this->assertEquals($expected, $property->generate());
	}

	/**
	 * Test if can generate a static property with a value.
	 */
	public function testGenerateStaticPropertyWithValue() {

		$file = Bootstrap::$resourceDir . '/manitou/generators/php/property_static_value.txt';
		$expected = $this->getFileContent($file);

		$property = new PHPProperty('index', new PHPValue(1));
		$property->setStatic(true);

		$this->assertEquals($expected, $property->generate());
	}

	/**
	 * Test if can generate a property with a DocBlock.
	 */
	public function testGeneratePropertyWithDocBlock() {

		$file = Bootstrap::$resourceDir . '/manitou/generators/php/property_docblock.txt';
		$expected = $this->getFileContent($file);

		$property = new PHPProperty('index');
		$property->setDocBlock(new PHPDocBlock());

		$this->assertEquals($expected, $property->generate());
	}

	/**
	 * Test if throws an exception if the visibility is unexpected.
	 *
	 * @expectedException \com\mohiva\manitou\exceptions\UnexpectedVisibilityException
	 */
	public function testErrorOnUnexpectedVisibility() {

		$property = new PHPProperty('name', null, 4);
		$property->generate();
	}
}
