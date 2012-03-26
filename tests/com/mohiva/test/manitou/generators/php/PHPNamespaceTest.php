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
use com\mohiva\manitou\generators\php\PHPNamespace;
use com\mohiva\manitou\generators\php\PHPUse;
use com\mohiva\manitou\generators\php\PHPInterface;
use com\mohiva\manitou\generators\php\PHPClass;

/**
 * Unit test case for the `PHPNamespace` class.
 *
 * @category  Mohiva/Manitou
 * @package   Mohiva/Manitou/Test
 * @author    Christian Kaps <christian.kaps@mohiva.com>
 * @copyright Copyright (c) 2007-2012 Christian Kaps (http://www.mohiva.com)
 * @license   https://github.com/mohiva/manitou/blob/master/LICENSE.textile New BSD License
 * @link      https://github.com/mohiva/manitou
 */
class PHPNamespaceTest extends AbstractGenerator {

	/**
	 * Test if can set or get the namespace name.
	 */
	public function testNameAccessors() {

		$namespace = new PHPNamespace();
		$namespace->setName('\com\mohiva\test');

		$this->assertSame('com\mohiva\test', $namespace->getName());
	}

	/**
	 * Test if can set or get the bracketed property.
	 */
	public function testBracketedAccessors() {

		$namespace = new PHPNamespace();
		$namespace->setBracketed(true);

		$this->assertTrue($namespace->isBracketed());
	}

	/**
	 * Test if can set or get use statements.
	 */
	public function testUseStatementAccessors() {

		$use1 = new PHPUse('com\mohiva\test1');
		$use2 = new PHPUse('com\mohiva\test2');
		$expected = array(
			spl_object_hash($use1) => $use1,
			spl_object_hash($use2) => $use2
		);

		$namespace = new PHPNamespace();
		$namespace->setUseStatements($expected);

		$this->assertEquals($expected, $namespace->getUseStatements());
	}

	/**
	 * Test if can add multiple use statements.
	 */
	public function testAddUseStatements() {

		$use1 = new PHPUse('com\mohiva\test1');
		$use2 = new PHPUse('com\mohiva\test2');
		$expected = array(
			spl_object_hash($use1) => $use1,
			spl_object_hash($use2) => $use2
		);

		$namespace = new PHPNamespace();
		$namespace->addUseStatement($use1);
		$namespace->addUseStatement($use2);

		$this->assertEquals($expected, $namespace->getUseStatements());
	}

	/**
	 * Test if can remove multiple use statements.
	 */
	public function testRemoveUseStatements() {

		$use1 = new PHPUse('com\mohiva\test1');
		$use2 = new PHPUse('com\mohiva\test2');

		$namespace = new PHPNamespace();
		$namespace->addUseStatement($use1);
		$namespace->addUseStatement($use2);
		$namespace->removeUseStatement($use1);
		$namespace->removeUseStatement($use2);

		$this->assertEquals(array(), $namespace->getUseStatements());
	}

	/**
	 * Test if can set or get classes.
	 */
	public function testClassAccessors() {

		$class1 = new PHPClass('Class1');
		$class2 = new PHPClass('Class2');
		$expected = array(
			spl_object_hash($class1) => $class1,
			spl_object_hash($class2) => $class2
		);

		$namespace = new PHPNamespace();
		$namespace->setClasses($expected);

		$this->assertEquals($expected, $namespace->getClasses());
	}

	/**
	 * Test if can add multiple classes.
	 */
	public function testAddClasses() {

		$class1 = new PHPClass('Class1');
		$class2 = new PHPClass('Class2');
		$expected = array(
			spl_object_hash($class1) => $class1,
			spl_object_hash($class2) => $class2
		);

		$namespace = new PHPNamespace();
		$namespace->addClass($class1);
		$namespace->addClass($class2);

		$this->assertEquals($expected, $namespace->getClasses());
	}

	/**
	 * Test if can remove multiple classes.
	 */
	public function testRemoveClasses() {

		$class1 = new PHPClass('Class1');
		$class2 = new PHPClass('Class2');

		$namespace = new PHPNamespace();
		$namespace->addClass($class1);
		$namespace->addClass($class2);
		$namespace->removeClass($class1);
		$namespace->removeClass($class2);

		$this->assertEquals(array(), $namespace->getClasses());
	}

	/**
	 * Test if can set or get interfaces.
	 */
	public function testInterfaceAccessors() {

		$interface1 = new PHPInterface('Interface1');
		$interface2 = new PHPInterface('Interface2');
		$expected = array(
			spl_object_hash($interface1) => $interface1,
			spl_object_hash($interface2) => $interface2
		);

		$namespace = new PHPNamespace();
		$namespace->setInterfaces($expected);

		$this->assertEquals($expected, $namespace->getInterfaces());
	}

	/**
	 * Test if can add multiple interfaces.
	 */
	public function testAddInterfaces() {

		$interface1 = new PHPInterface('Interface1');
		$interface2 = new PHPInterface('Interface2');
		$expected = array(
			spl_object_hash($interface1) => $interface1,
			spl_object_hash($interface2) => $interface2
		);

		$namespace = new PHPNamespace();
		$namespace->addInterface($interface1);
		$namespace->addInterface($interface2);

		$this->assertEquals($expected, $namespace->getInterfaces());
	}

	/**
	 * Test if can remove multiple interfaces.
	 */
	public function testRemoveInterfaces() {

		$interface1 = new PHPInterface('Interface1');
		$interface2 = new PHPInterface('Interface2');

		$namespace = new PHPNamespace();
		$namespace->addInterface($interface1);
		$namespace->addInterface($interface2);
		$namespace->removeInterface($interface1);
		$namespace->removeInterface($interface2);

		$this->assertEquals(array(), $namespace->getInterfaces());
	}

	/**
	 * Test if can generate an empty namespace without braces.
	 */
	public function testGenerateEmptyNamespaceWithoutBraces() {

		$file = Bootstrap::$resourceDir . '/manitou/generators/php/namespace.txt';
		$expected = $this->getFileContent($file);

		$namespace = new PHPNamespace('\com\mohiva\test');

		$this->assertEquals($expected, $namespace->generate());
	}

	/**
	 * Test if can generate an empty namespace without braces.
	 */
	public function testGenerateEmptyNamespaceWithBraces() {

		$file = Bootstrap::$resourceDir . '/manitou/generators/php/namespace_braces.txt';
		$expected = $this->getFileContent($file);

		$namespace = new PHPNamespace('\com\mohiva\test', true);

		$this->assertEquals($expected, $namespace->generate());
	}

	/**
	 * Test if can generate a global namespace with braces.
	 */
	public function testGenerateGlobalNamespaceWithBraces() {

		$file = Bootstrap::$resourceDir . '/manitou/generators/php/namespace_braces_global.txt';
		$expected = $this->getFileContent($file);

		$namespace = new PHPNamespace(null, true);

		$this->assertEquals($expected, $namespace->generate());
	}

	/**
	 * Test if throws an exception when creating a global namespace without braces.
	 *
	 * @expectedException \com\mohiva\manitou\exceptions\GlobalNamespaceWithoutBracesException
	 */
	public function testGenerateGlobalNamespaceWithoutBraces() {

		$namespace = new PHPNamespace(null, false);
		$namespace->generate();
	}

	/**
	 * Test if can generate a namespace with braces and use statements.
	 */
	public function testGenerateNamespaceWithBracesAndUseStatements() {

		$file = Bootstrap::$resourceDir . '/manitou/generators/php/namespace_braces_use.txt';
		$expected = $this->getFileContent($file);

		$namespace = new PHPNamespace('com\mohiva\test', true);
		$namespace->addUseStatement(new PHPUse('com\mohiva\framework\xml\XMLDocument'));
		$namespace->addUseStatement(new PHPUse('com\mohiva\framework\xml\XMLElement'));
		$namespace->addUseStatement(new PHPUse('com\mohiva\framework\mfx', 'mymfx'));

		$this->assertEquals($expected, $namespace->generate());
	}

	/**
	 * Test if can generate a namespace without braces and use statements.
	 */
	public function testGenerateNamespaceWithoutBracesAndWithUseStatements() {

		$file = Bootstrap::$resourceDir . '/manitou/generators/php/namespace_use.txt';
		$expected = $this->getFileContent($file);

		$namespace = new PHPNamespace('com\mohiva\test');
		$namespace->addUseStatement(new PHPUse('com\mohiva\framework\xml\XMLDocument'));
		$namespace->addUseStatement(new PHPUse('com\mohiva\framework\xml\XMLElement'));
		$namespace->addUseStatement(new PHPUse('com\mohiva\framework\mfx', 'mymfx'));

		$this->assertEquals($expected, $namespace->generate());
	}

	/**
	 * Test if can generate a namespace with braces and classes.
	 */
	public function testGenerateNamespaceWithBracesAndClasses() {

		$file = Bootstrap::$resourceDir . '/manitou/generators/php/namespace_braces_classes.txt';
		$expected = $this->getFileContent($file);

		$namespace = new PHPNamespace('com\mohiva\test', true);
		$namespace->addClass(new PHPClass('Test1'));
		$namespace->addClass(new PHPClass('Test2'));

		$this->assertEquals($expected, $namespace->generate());
	}

	/**
	 * Test if can generate a namespace without braces and with classes.
	 */
	public function testGenerateNamespaceWithoutBracesAndWithClasses() {

		$file = Bootstrap::$resourceDir . '/manitou/generators/php/namespace_classes.txt';
		$expected = $this->getFileContent($file);

		$namespace = new PHPNamespace('com\mohiva\test');
		$namespace->addClass(new PHPClass('Test1'));
		$namespace->addClass(new PHPClass('Test2'));

		$this->assertEquals($expected, $namespace->generate());
	}

	/**
	 * Test if can generate a namespace with braces and interfaces.
	 */
	public function testGenerateNamespaceWithBracesAndInterfaces() {

		$file = Bootstrap::$resourceDir . '/manitou/generators/php/namespace_braces_interfaces.txt';
		$expected = $this->getFileContent($file);

		$namespace = new PHPNamespace('com\mohiva\test', true);
		$namespace->addInterface(new PHPInterface('Test1'));
		$namespace->addInterface(new PHPInterface('Test2'));

		$this->assertEquals($expected, $namespace->generate());
	}

	/**
	 * Test if can generate a namespace without braces and with interfaces.
	 */
	public function testGenerateNamespaceWithoutBracesAndWithInterfaces() {

		$file = Bootstrap::$resourceDir . '/manitou/generators/php/namespace_interfaces.txt';
		$expected = $this->getFileContent($file);

		$namespace = new PHPNamespace('com\mohiva\test');
		$namespace->addInterface(new PHPInterface('Test1'));
		$namespace->addInterface(new PHPInterface('Test2'));

		$this->assertEquals($expected, $namespace->generate());
	}

	/**
	 * Test if can generate a complex namespace without braces.
	 */
	public function testGenerateComplexNamespaceWithoutBraces() {

		$file = Bootstrap::$resourceDir . '/manitou/generators/php/namespace_complex.txt';
		$expected = $this->getFileContent($file);

		$namespace = new PHPNamespace('com\mohiva\test');
		$namespace->addUseStatement(new PHPUse('com\mohiva\framework\xml\XMLDocument'));
		$namespace->addUseStatement(new PHPUse('com\mohiva\framework\xml\XMLElement'));
		$namespace->addUseStatement(new PHPUse('com\mohiva\framework\mfx', 'mymfx'));
		$namespace->addClass((new PHPClass('Test1'))->setDocBlock(new PHPDocBlock()));
		$namespace->addClass((new PHPClass('Test2'))->setDocBlock(new PHPDocBlock()));
		$namespace->addInterface((new PHPInterface('Test1'))->setDocBlock(new PHPDocBlock()));
		$namespace->addInterface((new PHPInterface('Test2'))->setDocBlock(new PHPDocBlock()));

		$this->assertEquals($expected, $namespace->generate());
	}

	/**
	 * Test if can generate a complex namespace with braces.
	 */
	public function testGenerateComplexNamespaceWithBraces() {

		$file = Bootstrap::$resourceDir . '/manitou/generators/php/namespace_braces_complex.txt';
		$expected = $this->getFileContent($file);

		$namespace = new PHPNamespace('com\mohiva\test');
		$namespace->setBracketed(true);
		$namespace->addUseStatement(new PHPUse('com\mohiva\framework\xml\XMLDocument'));
		$namespace->addUseStatement(new PHPUse('com\mohiva\framework\xml\XMLElement'));
		$namespace->addUseStatement(new PHPUse('com\mohiva\framework\mfx', 'mymfx'));
		$namespace->addClass((new PHPClass('Test1'))->setDocBlock(new PHPDocBlock()));
		$namespace->addClass((new PHPClass('Test2'))->setDocBlock(new PHPDocBlock()));
		$namespace->addInterface((new PHPInterface('Test1'))->setDocBlock(new PHPDocBlock()));
		$namespace->addInterface((new PHPInterface('Test2'))->setDocBlock(new PHPDocBlock()));

		$this->assertEquals($expected, $namespace->generate());
	}
}
