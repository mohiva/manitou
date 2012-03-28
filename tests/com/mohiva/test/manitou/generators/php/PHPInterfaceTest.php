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
use com\mohiva\manitou\generators\php\PHPDocBlock;
use com\mohiva\manitou\generators\php\PHPInterface;
use com\mohiva\manitou\generators\php\PHPMember;
use com\mohiva\manitou\generators\php\PHPConstant;
use com\mohiva\manitou\generators\php\PHPMethod;
use com\mohiva\manitou\generators\php\PHPParameter;
use com\mohiva\manitou\generators\php\PHPValue;

/**
 * Unit test case for the `PHPInterface` class.
 *
 * @category  Mohiva/Manitou
 * @package   Mohiva/Manitou/Test
 * @author    Christian Kaps <christian.kaps@mohiva.com>
 * @copyright Copyright (c) 2007-2012 Christian Kaps (http://www.mohiva.com)
 * @license   https://github.com/mohiva/manitou/blob/master/LICENSE.textile New BSD License
 * @link      https://github.com/mohiva/manitou
 */
class PHPInterfaceTest extends AbstractGenerator {

	/**
	 * Test all getters for the values set with the constructor.
	 */
	public function testConstructorAccessors() {

		$name = sha1(microtime(true));
		$parentInterface = sha1(microtime(true));
		$parentInterfaces = array(sha1($parentInterface) => $parentInterface);
		$interface = new PHPInterface(
			$name,
			$parentInterfaces
		);

		$this->assertSame($name, $interface->getName());
		$this->assertSame($parentInterfaces, $interface->getParentInterfaces());
	}

	/**
	 * Test the `setName` and `getName` accessors.
	 */
	public function testNameAccessors() {

		$name = sha1(microtime(true));

		$interface = new PHPInterface('Test');
		$interface->setName($name);

		$this->assertSame($name, $interface->getName());
	}

	/**
	 * Test the `setParentInterfaces` and `getParentInterfaces` accessors.
	 */
	public function testParentInterfacesAccessors() {

		$parentInterface = sha1(microtime(true));
		$parentInterfaces = array(sha1($parentInterface) => $parentInterface);

		$interface = new PHPInterface('Test');
		$interface->setParentInterfaces($parentInterfaces);

		$this->assertSame($parentInterfaces, $interface->getParentInterfaces());
	}

	/**
	 * Test if can add multiple parent interfaces.
	 */
	public function testAddParentInterface() {

		$parentInterface1 = sha1(microtime(true));
		$parentInterface2 = sha1(microtime(true));
		$expected = array(
			sha1($parentInterface1) => $parentInterface1,
			sha1($parentInterface2) => $parentInterface2
		);

		$interface = new PHPInterface('Test');
		$interface->addParentInterface($parentInterface1);
		$interface->addParentInterface($parentInterface2);

		$this->assertSame($expected, $interface->getParentInterfaces());
	}

	/**
	 * Test if can remove multiple parent interfaces.
	 */
	public function testRemoveParentInterface() {

		$parentInterface1 = sha1(microtime(true));
		$parentInterface2 = sha1(microtime(true));
		$interface = new PHPInterface('Test');
		$interface->addParentInterface($parentInterface1);
		$interface->addParentInterface($parentInterface2);
		$interface->removeParentInterface($parentInterface1);
		$interface->removeParentInterface($parentInterface2);

		$this->assertSame(array(), $interface->getParentInterfaces());
	}

	/**
	 * Test the `setConstants` and `getConstants` accessors.
	 */
	public function testConstantAccessors() {

		$constant = new PHPConstant('TEST', new PHPValue(1));
		$constants = array(spl_object_hash($constant) => $constant);

		$interface = new PHPInterface('Test');
		$interface->setConstants($constants);

		$this->assertSame($constants, $interface->getConstants());
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

		$interface = new PHPInterface('Test');
		$interface->addConstant($constant1);
		$interface->addConstant($constant2);

		$this->assertSame($expected, $interface->getConstants());
	}

	/**
	 * Test if can remove multiple constants.
	 */
	public function testRemoveConstants() {

		$constant1 = new PHPConstant('TEST1', new PHPValue(1));
		$constant2 = new PHPConstant('TEST2', new PHPValue(1));

		$interface = new PHPInterface('Test');
		$interface->addConstant($constant1);
		$interface->addConstant($constant2);
		$interface->removeConstant($constant1);
		$interface->removeConstant($constant2);

		$this->assertSame(array(), $interface->getConstants());
	}

	/**
	 * Test the `setMethods` and `getMethods` accessors.
	 */
	public function testMethodAccessors() {

		$method = new PHPMethod('test');
		$methods = array(spl_object_hash($method) => $method);

		$interface = new PHPInterface('Test');
		$interface->setMethods($methods);

		$this->assertSame($methods, $interface->getMethods());
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

		$interface = new PHPInterface('Test');
		$interface->addMethod($method1);
		$interface->addMethod($method2);

		$this->assertSame($expected, $interface->getMethods());
	}

	/**
	 * Test if can remove multiple methods.
	 */
	public function testRemoveMethods() {

		$method1 = new PHPMethod('test1');
		$method2 = new PHPMethod('test2');

		$interface = new PHPInterface('Test');
		$interface->addMethod($method1);
		$interface->addMethod($method2);
		$interface->removeMethod($method1);
		$interface->removeMethod($method2);

		$this->assertSame(array(), $interface->getMethods());
	}

	/**
	 * Test the `setDocBlock` and `getDocBlock` accessors.
	 */
	public function testDocBlockAccessors() {

		$docBlock = new PHPDocBlock;
		$interface = new PHPInterface('Test');
		$interface->setDocBlock($docBlock);

		$this->assertSame($docBlock, $interface->getDocBlock());
	}

	/**
	 * Test if can generate an interface which extends a parent class.
	 */
	public function testGenerateInterfaceWhichExtendsParents() {

		$file = Bootstrap::$resourceDir . '/manitou/generators/php/interface_extends.txt';
		$expected = $this->getFileContent($file);

		$interface = new PHPInterface('Test', array('Serializable', 'Countable'));

		$this->assertEquals($expected, $interface->generate());
	}

	/**
	 * Test if can generate an interface with a DocBlock.
	 */
	public function testGenerateInterfaceWithDocBlock() {

		$file = Bootstrap::$resourceDir . '/manitou/generators/php/interface_docblock.txt';
		$expected = $this->getFileContent($file);

		$interface = new PHPInterface('Test');
		$interface->setDocBlock(new PHPDocBlock());

		$this->assertEquals($expected, $interface->generate());
	}

	/**
	 * Test if can generate an interface with constants.
	 */
	public function testGenerateInterfaceWithConstants() {

		$file = Bootstrap::$resourceDir . '/manitou/generators/php/interface_constants.txt';
		$expected = $this->getFileContent($file);

		$interface = new PHPInterface('Test');
		$interface->addConstant(new PHPConstant('VISIBILITY_PUBLIC', new PHPValue(1)));
		$interface->addConstant(new PHPConstant('VISIBILITY_PROTECTED', new PHPValue(2)));
		$interface->addConstant(new PHPConstant('VISIBILITY_PRIVATE', new PHPValue(3)));

		$this->assertEquals($expected, $interface->generate());
	}

	/**
	 * Test if can generate an interface with methods.
	 */
	public function testGenerateInterfaceWithMethods() {

		$file = Bootstrap::$resourceDir . '/manitou/generators/php/interface_methods.txt';
		$expected = $this->getFileContent($file);

		$interface = new PHPInterface('Test');
		$interface->addMethod(new PHPMethod('__construct', PHPMember::VISIBILITY_PUBLIC, PHPMethod::SCOPE_INTERFACE));
		$interface->addMethod(new PHPMethod('calculate', PHPMember::VISIBILITY_PROTECTED, PHPMethod::SCOPE_INTERFACE));
		$interface->addMethod(new PHPMethod('draw', PHPMember::VISIBILITY_PRIVATE, PHPMethod::SCOPE_INTERFACE));

		$this->assertEquals($expected, $interface->generate());
	}

	/**
	 * Test if can generate a complex interface.
	 */
	public function testGenerateComplexInterface() {

		$file = Bootstrap::$resourceDir . '/manitou/generators/php/interface_complex.txt';
		$expected = $this->getFileContent($file);

		$this->assertEquals($expected, (new PHPInterface('Test'))
			->setParentInterfaces(array('Serializable', 'Countable'))
			->setDocBlock((new PHPDocBlock())->addSection('A complex interface example.'))
			->addConstant((new PHPConstant('TYPE_HTTP', new PHPValue(1)))->setDocBlock(new PHPDocBlock()))
			->addConstant((new PHPConstant('TYPE_CLI', new PHPValue(2)))->setDocBlock(new PHPDocBlock()))
			->addMethod((new PHPMethod('__construct'))
				->setScope(PHPMethod::SCOPE_INTERFACE)
				->addParameter(new PHPParameter('type'))
				->setDocBlock((new PHPDocBlock())->addSection('The class constructor.')))
			->generate()
		);
	}
}
