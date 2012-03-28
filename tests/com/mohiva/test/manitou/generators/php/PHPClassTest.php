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
	 * Test all getters for the values set with the constructor.
	 */
	public function testConstructorAccessors() {

		$name = sha1(microtime(true));
		$parentClass = sha1(microtime(true));
		$interface = sha1(microtime(true));
		$implInterfaces = array(sha1($interface) => $interface);
		$isAbstract = (bool) mt_rand(0, 1);
		$isFinal = (bool) mt_rand(0, 1);
		$class = new PHPClass(
			$name,
			$parentClass,
			$implInterfaces,
			$isAbstract,
			$isFinal
		);

		$this->assertSame($name, $class->getName());
		$this->assertSame($parentClass, $class->getParentClass());
		$this->assertSame($implInterfaces, $class->getImplInterfaces());
		$this->assertSame($isAbstract, $class->isAbstract());
		$this->assertSame($isFinal, $class->isFinal());
	}

	/**
	 * Test the `setName` and `getName` accessors.
	 */
	public function testNameAccessors() {

		$name = sha1(microtime(true));

		$class = new PHPClass('Test');
		$class->setName($name);

		$this->assertSame($name, $class->getName());
	}

	/**
	 * Test the `setParentClass` and `getParentClass` accessors.
	 */
	public function testParentClassAccessors() {

		$parentClass = sha1(microtime(true));

		$class = new PHPClass('Test');
		$class->setParentClass($parentClass);

		$this->assertSame($parentClass, $class->getParentClass());
	}

	/**
	 * Test the `setImplInterfaces` and `getImplInterfaces` accessors.
	 */
	public function testImplInterfacesAccessors() {

		$interface = sha1(microtime(true));
		$implInterfaces = array(sha1($interface) => $interface);

		$class = new PHPClass('Test');
		$class->setImplInterfaces($implInterfaces);

		$this->assertSame($implInterfaces, $class->getImplInterfaces());
	}

	/**
	 * Test if can add multiple implemented interfaces.
	 */
	public function testAddImplInterface() {

		$interface1 = sha1(microtime(true));
		$interface2 = sha1(microtime(true));
		$expected = array(
			sha1($interface1) => $interface1,
			sha1($interface2) => $interface2
		);

		$class = new PHPClass('Test');
		$class->addImplInterface($interface1);
		$class->addImplInterface($interface2);

		$this->assertSame($expected, $class->getImplInterfaces());
	}

	/**
	 * Test if can remove multiple implemented interfaces.
	 */
	public function testRemoveImplInterface() {

		$interface1 = sha1(microtime(true));
		$interface2 = sha1(microtime(true));

		$class = new PHPClass('Test');
		$class->addImplInterface($interface1);
		$class->addImplInterface($interface2);
		$class->removeImplInterface($interface1);
		$class->removeImplInterface($interface2);

		$this->assertSame(array(), $class->getImplInterfaces());
	}

	/**
	 * Test the `setAbstract` and `isAbstract` accessors.
	 */
	public function testAbstractAccessors() {

		$class = new PHPClass('Test');
		$class->setAbstract(false);

		$this->assertFalse($class->isAbstract());
	}

	/**
	 * Test the `setFinal` and `isFinal` accessors.
	 */
	public function testFinalAccessors() {

		$class = new PHPClass('Test');
		$class->setFinal(false);

		$this->assertFalse($class->isFinal());
	}

	/**
	 * Test the `setConstants` and `getConstants` accessors.
	 */
	public function testConstantAccessors() {

		$constant = new PHPConstant('TEST', new PHPValue(1));
		$constants = array(spl_object_hash($constant) => $constant);

		$class = new PHPClass('Test');
		$class->setConstants($constants);

		$this->assertSame($constants, $class->getConstants());
	}

	/**
	 * Test if can add multiple constants.
	 */
	public function testAddConstants() {

		$constant1 = new PHPConstant('TEST1', new PHPValue(1));
		$constant2 = new PHPConstant('TEST2', new PHPValue(1));
		$expected = array(
			spl_object_hash($constant1) => $constant1,
			spl_object_hash($constant2) => $constant2
		);

		$class = new PHPClass('Test');
		$class->addConstant($constant1);
		$class->addConstant($constant2);

		$this->assertSame($expected, $class->getConstants());
	}

	/**
	 * Test if can remove multiple constants.
	 */
	public function testRemoveConstants() {

		$constant1 = new PHPConstant('TEST1', new PHPValue(1));
		$constant2 = new PHPConstant('TEST2', new PHPValue(1));

		$class = new PHPClass('Test');
		$class->addConstant($constant1);
		$class->addConstant($constant2);
		$class->removeConstant($constant1);
		$class->removeConstant($constant2);

		$this->assertSame(array(), $class->getConstants());
	}

	/**
	 * Test the `setProperties` and `getProperties` accessors.
	 */
	public function testPropertyAccessors() {

		$property = new PHPProperty('test');
		$properties = array(spl_object_hash($property) => $property);

		$class = new PHPClass('Test');
		$class->setProperties($properties);

		$this->assertSame($properties, $class->getProperties());
	}

	/**
	 * Test if can add multiple properties.
	 */
	public function testAddProperties() {

		$property1 = new PHPProperty('test1');
		$property2 = new PHPProperty('test2');
		$expected = array(
			spl_object_hash($property1) => $property1,
			spl_object_hash($property2) => $property2
		);

		$class = new PHPClass('Test');
		$class->addProperty($property1);
		$class->addProperty($property2);

		$this->assertSame($expected, $class->getProperties());
	}

	/**
	 * Test if can remove multiple properties.
	 */
	public function testRemoveProperties() {

		$property1 = new PHPProperty('test1');
		$property2 = new PHPProperty('test2');

		$class = new PHPClass('Test');
		$class->addProperty($property1);
		$class->addProperty($property2);
		$class->removeProperty($property1);
		$class->removeProperty($property2);

		$this->assertSame(array(), $class->getProperties());
	}

	/**
	 * Test the `setMethods` and `getMethods` accessors.
	 */
	public function testMethodAccessors() {

		$method = new PHPMethod('test');
		$methods = array(spl_object_hash($method) => $method);

		$class = new PHPClass('Test');
		$class->setMethods($methods);

		$this->assertSame($methods, $class->getMethods());
	}

	/**
	 * Test if can add multiple methods.
	 */
	public function testAddMethods() {

		$method1 = new PHPMethod('test1');
		$method2 = new PHPMethod('test2');
		$expected = array(
			spl_object_hash($method1) => $method1,
			spl_object_hash($method2) => $method2
		);

		$class = new PHPClass('Test');
		$class->addMethod($method1);
		$class->addMethod($method2);

		$this->assertSame($expected, $class->getMethods());
	}

	/**
	 * Test if can remove multiple methods.
	 */
	public function testRemoveMethods() {

		$method1 = new PHPMethod('test1');
		$method2 = new PHPMethod('test2');

		$class = new PHPClass('Test');
		$class->addMethod($method1);
		$class->addMethod($method2);
		$class->removeMethod($method1);
		$class->removeMethod($method2);

		$this->assertSame(array(), $class->getMethods());
	}

	/**
	 * Test the `setDocBlock` and `getDocBlock` accessors.
	 */
	public function testDocBlockAccessors() {

		$docBlock = new PHPDocBlock();
		$class = new PHPClass('Test');
		$class->setDocBlock($docBlock);

		$this->assertSame($docBlock, $class->getDocBlock());
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
