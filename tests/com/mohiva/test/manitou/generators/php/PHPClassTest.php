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
use com\mohiva\manitou\generators\php\PHPClass;
use com\mohiva\manitou\generators\php\PHPMethod;
use com\mohiva\manitou\generators\php\PHPDocBlock;
use com\mohiva\manitou\generators\php\PHPMember;
use com\mohiva\manitou\generators\php\PHPConstant;
use com\mohiva\manitou\generators\php\PHPParameter;
use com\mohiva\manitou\generators\php\PHPProperty;
use com\mohiva\manitou\generators\php\PHPRawCode;
use com\mohiva\manitou\generators\php\PHPValue;

/**
 * Unit test case for the `PHPClass` class.
 *
 * @category  Mohiva/Manitou
 * @package   Mohiva/Manitou/Test
 * @author    Christian Kaps <christian.kaps@mohiva.com>
 * @copyright Copyright (c) 2007-2012 Christian Kaps (http://www.mohiva.com)
 * @license   https://github.com/mohiva/manitou/blob/master/LICENSE.textile New BSD License
 * @link      https://github.com/mohiva/manitou
 */
class PHPClassTest extends AbstractGenerator {

	/**
	 * Test if can set or get the name of a class.
	 */
	public function testNameAccessors() {

		$class = new PHPClass('Test1');

		$this->assertSame('Test1', $class->getName());

		$class->setName('Test2');

		$this->assertSame('Test2', $class->getName());
	}

	/**
	 * Test if can set or get the inherited class.
	 */
	public function testParentClassAccessors() {

		$class = new PHPClass('TestClass', 'TestParent1');

		$this->assertSame('TestParent1', $class->getParentClass());

		$class->setParentClass('TestParent2');

		$this->assertSame('TestParent2', $class->getParentClass());
	}

	/**
	 * Test if can set or get the implemented interface list.
	 */
	public function testImplInterfacesAccessors() {

		$expected1 = array(sha1('Countable') => 'Countable');
		$expected2 = array(sha1('OuterIterator') => 'OuterIterator');

		$class = new PHPClass('Test', null, array('Countable'));

		$this->assertSame($expected1, $class->getImplInterfaces());

		$class->setImplInterfaces(array('OuterIterator'));

		$this->assertSame($expected2, $class->getImplInterfaces());
	}

	/**
	 * Test if can add multiple implemented interfaces.
	 */
	public function testAddImplInterface() {

		$expected = array(
			sha1('Countable') => 'Countable',
			sha1('OuterIterator') => 'OuterIterator'
		);

		$class = new PHPClass('Test');
		$class->addImplInterface('Countable');
		$class->addImplInterface('OuterIterator');

		$this->assertSame($expected, $class->getImplInterfaces());
	}

	/**
	 * Test if can remove multiple implemented interfaces.
	 */
	public function testRemoveImplInterface() {

		$class = new PHPClass('Test');
		$class->addImplInterface('Countable');
		$class->addImplInterface('OuterIterator');
		$class->removeImplInterface('Countable');
		$class->removeImplInterface('OuterIterator');

		$this->assertSame(array(), $class->getImplInterfaces());
	}

	/**
	 * Test if can set or get the abstract property of the class.
	 */
	public function testAbstractAccessors() {

		$class = new PHPClass('Test', null, array(), true);

		$this->assertTrue($class->isAbstract());

		$class->setAbstract(false);

		$this->assertFalse($class->isAbstract());
	}

	/**
	 * Test if can set or get the final property of the class.
	 */
	public function testFinalAccessors() {

		$class = new PHPClass('Test', null, array(), true, true);

		$this->assertTrue($class->isFinal());

		$class->setFinal(false);

		$this->assertFalse($class->isFinal());
	}

	/**
	 * Test if can set or get a DocBlock object.
	 */
	public function testDocBlockAccessors() {

		$class = new PHPClass('Test');
		$class->setDocBlock(new PHPDocBlock());

		$this->assertInstanceOf('com\mohiva\manitou\generators\php\PHPDocBlock', $class->getDocBlock());
	}

	/**
	 * Test if can generate a final class.
	 */
	public function testGenerateFinalClass() {

		$file = Bootstrap::$resourceDir . '/manitou/generators/php/class_final.txt';
		$expected = $this->getFileContent($file);

		$class = new PHPClass('Test');
		$class->setFinal(true);

		$this->assertEquals($expected, $class->generate());
	}

	/**
	 * Test if can generate a abstract class.
	 */
	public function testGenerateAbstractClass() {

		$file = Bootstrap::$resourceDir . '/manitou/generators/php/class_abstract.txt';
		$expected = $this->getFileContent($file);

		$class = new PHPClass('Test');
		$class->setAbstract(true);

		$this->assertEquals($expected, $class->generate());
	}

	/**
	 * Test if can generate a class which extends a parent class.
	 */
	public function testGenerateClassWhichExtendsParent() {

		$file = Bootstrap::$resourceDir . '/manitou/generators/php/class_extends.txt';
		$expected = $this->getFileContent($file);

		$class = new PHPClass('Test', 'TestAbstract');

		$this->assertEquals($expected, $class->generate());
	}

	/**
	 * Test if can generate a class which implements interfaces.
	 */
	public function testGenerateClassWhichImplementsInterfaces() {

		$file = Bootstrap::$resourceDir . '/manitou/generators/php/class_implements.txt';
		$expected = $this->getFileContent($file);

		$class = new PHPClass('Test');
		$class->addImplInterface('Countable');
		$class->addImplInterface('Serializable');

		$this->assertEquals($expected, $class->generate());
	}

	/**
	 * Test if can generate a class which extends a parent class and implements a interface.
	 */
	public function testGenerateClassWhichExtendsParentAndImplementsInterface() {

		$file = Bootstrap::$resourceDir . '/manitou/generators/php/class_extends_implements.txt';
		$expected = $this->getFileContent($file);

		$class = new PHPClass('Test', 'AbstractTest', array('Serializable'));

		$this->assertEquals($expected, $class->generate());
	}

	/**
	 * Test if can generate a class with a DocBlock.
	 */
	public function testGenerateClassWithDocBlock() {

		$file = Bootstrap::$resourceDir . '/manitou/generators/php/class_docblock.txt';
		$expected = $this->getFileContent($file);

		$class = new PHPClass('Test');
		$class->setDocBlock(new PHPDocBlock());

		$this->assertEquals($expected, $class->generate());
	}

	/**
	 * Test if can generate a class with constants.
	 */
	public function testGenerateClassWithConstants() {

		$file = Bootstrap::$resourceDir . '/manitou/generators/php/class_constants.txt';
		$expected = $this->getFileContent($file);

		$class = new PHPClass('Test');
		$class->addConstant(new PHPConstant('VISIBILITY_PUBLIC', new PHPValue(1)));
		$class->addConstant(new PHPConstant('VISIBILITY_PROTECTED', new PHPValue(2)));
		$class->addConstant(new PHPConstant('VISIBILITY_PRIVATE', new PHPValue(3)));

		$this->assertEquals($expected, $class->generate());
	}

	/**
	 * Test if can generate a class with properties.
	 */
	public function testGenerateClassWithProperties() {

		$file = Bootstrap::$resourceDir . '/manitou/generators/php/class_properties.txt';
		$expected = $this->getFileContent($file);

		$class = new PHPClass('Test');
		$class->addProperty(new PHPProperty('public', new PHPValue(null), PHPProperty::VISIBILITY_PUBLIC));
		$class->addProperty(new PHPProperty('protected', new PHPValue(null), PHPProperty::VISIBILITY_PROTECTED));
		$class->addProperty(new PHPProperty('private', new PHPValue(null), PHPProperty::VISIBILITY_PRIVATE));

		$this->assertEquals($expected, $class->generate());
	}

	/**
	 * Test if can generate a class with methods.
	 */
	public function testGenerateClassWithMethods() {

		$file = Bootstrap::$resourceDir . '/manitou/generators/php/class_methods.txt';
		$expected = $this->getFileContent($file);

		$class = new PHPClass('Test');
		$class->addMethod(new PHPMethod('__construct', PHPMember::VISIBILITY_PUBLIC));
		$class->addMethod(new PHPMethod('calculate', PHPMember::VISIBILITY_PROTECTED));
		$class->addMethod(new PHPMethod('draw', PHPMember::VISIBILITY_PRIVATE));

		$this->assertEquals($expected, $class->generate());
	}

	/**
	 * Test if can generate a complex class.
	 */
	public function testGenerateComplexClass() {

		$file = Bootstrap::$resourceDir . '/manitou/generators/php/class_complex.txt';
		$expected = $this->getFileContent($file);

		$this->assertEquals($expected, (new PHPClass('Test'))
			->setParentClass('AbstractTest')
			->setImplInterfaces(array('Serializable', 'Countable'))
			->setFinal(true)
			->setDocBlock((new PHPDocBlock())->addSection('A complex class example.'))
			->addConstant((new PHPConstant('TYPE_HTTP', new PHPValue(1)))->setDocBlock(new PHPDocBlock()))
			->addConstant((new PHPConstant('TYPE_CLI', new PHPValue(2)))->setDocBlock(new PHPDocBlock()))
			->addProperty((new PHPProperty('type'))
				->setValue((new PHPValue('self::TYPE_CLI'))
					->setType(PHPValue::TYPE_CONSTANT))
				->setVisibility(PHPProperty::VISIBILITY_PROTECTED)
				->setDocBlock(new PHPDocBlock()))
			->addMethod((new PHPMethod('__construct'))
				->addParameter(new PHPParameter('type'))
				->setBody((new PHPRawCode())->addLine('$this->type = $type;'))
				->setDocBlock((new PHPDocBlock())->addSection('The class constructor.')))
			->generate()
		);
	}

	/**
	 * Test if throws an exception if the class is declared as abstract and as final.
	 *
	 * @expectedException \com\mohiva\manitou\exceptions\FinalAbstractClassException
	 */
	public function testThrowsExceptionIfAbstractClassContainsFinalKeyword() {

		$class = new PHPClass('Test');
		$class->setAbstract(true);
		$class->setFinal(true);
		$class->generate();
	}
}
