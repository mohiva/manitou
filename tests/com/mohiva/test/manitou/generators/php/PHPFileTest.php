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
use com\mohiva\manitou\generators\php\PHPFile;
use com\mohiva\manitou\generators\php\PHPDocBlock;
use com\mohiva\manitou\generators\php\PHPNamespace;
use com\mohiva\manitou\generators\php\PHPInterface;
use com\mohiva\manitou\generators\php\PHPClass;

/**
 * Unit test case for the `PHPFile` class.
 *
 * @category  Mohiva/Manitou
 * @package   Mohiva/Manitou/Test
 * @author    Christian Kaps <christian.kaps@mohiva.com>
 * @copyright Copyright (c) 2007-2012 Christian Kaps (http://www.mohiva.com)
 * @license   https://github.com/mohiva/manitou/blob/master/LICENSE.textile New BSD License
 * @link      https://github.com/mohiva/manitou
 */
class PHPFileTest extends AbstractGenerator {

	/**
	 * Test if can set or get a DocBlock object.
	 */
	public function testDocBlockAccessors() {

		$file = new PHPFile();
		$file->setDocBlock(new PHPDocBlock());

		$this->assertInstanceOf('com\mohiva\manitou\generators\php\PHPDocBlock', $file->getDocBlock());
	}

	/**
	 * Test if can set or get namespaces.
	 */
	public function testNamespacesAccessors() {

		$namespace1 = new PHPNamespace('com\mohiva\test1');
		$namespace2 = new PHPNamespace('com\mohiva\test2');
		$expected = array(
			spl_object_hash($namespace1) => $namespace1,
			spl_object_hash($namespace2) => $namespace2
		);

		$file = new PHPFile();
		$file->setNamespaces($expected);

		$this->assertEquals($expected, $file->getNamespaces());
	}

	/**
	 * Test if can add multiple namespaces.
	 */
	public function testAddNamespaces() {

		$namespace1 = new PHPNamespace('com\mohiva\test1');
		$namespace2 = new PHPNamespace('com\mohiva\test2');
		$expected = array(
			spl_object_hash($namespace1) => $namespace1,
			spl_object_hash($namespace2) => $namespace2
		);

		$file = new PHPFile();
		$file->addNamespace($namespace1);
		$file->addNamespace($namespace2);

		$this->assertEquals($expected, $file->getNamespaces());
	}

	/**
	 * Test if can remove multiple namespaces.
	 */
	public function testRemoveNamespaces() {

		$namespace1 = new PHPNamespace('com\mohiva\test1');
		$namespace2 = new PHPNamespace('com\mohiva\test2');

		$file = new PHPFile();
		$file->addNamespace($namespace1);
		$file->addNamespace($namespace2);
		$file->removeNamespace($namespace1);
		$file->removeNamespace($namespace2);

		$this->assertEquals(array(), $file->getNamespaces());
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

		$file = new PHPFile();
		$file->setClasses($expected);

		$this->assertEquals($expected, $file->getClasses());
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

		$file = new PHPFile();
		$file->addClass($class1);
		$file->addClass($class2);

		$this->assertEquals($expected, $file->getClasses());
	}

	/**
	 * Test if can remove multiple classes.
	 */
	public function testRemoveClasses() {

		$class1 = new PHPClass('Class1');
		$class2 = new PHPClass('Class2');

		$file = new PHPFile();
		$file->addClass($class1);
		$file->addClass($class2);
		$file->removeClass($class1);
		$file->removeClass($class2);

		$this->assertEquals(array(), $file->getClasses());
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

		$file = new PHPFile();
		$file->setInterfaces($expected);

		$this->assertEquals($expected, $file->getInterfaces());
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

		$file = new PHPFile();
		$file->addInterface($interface1);
		$file->addInterface($interface2);

		$this->assertEquals($expected, $file->getInterfaces());
	}

	/**
	 * Test if can remove multiple interfaces.
	 */
	public function testRemoveInterfaces() {

		$interface1 = new PHPInterface('Interface1');
		$interface2 = new PHPInterface('Interface2');

		$file = new PHPFile();
		$file->addInterface($interface1);
		$file->addInterface($interface2);
		$file->removeInterface($interface1);
		$file->removeInterface($interface2);

		$this->assertEquals(array(), $file->getInterfaces());
	}

	/**
	 * Test if can generate a file with namespaces.
	 */
	public function testGenerateFileWithNamespaces() {

		$file = Bootstrap::$resourceDir . '/manitou/generators/php/file_namespaces.txt';
		$expected = $this->getFileContent($file);

		$file = new PHPFile();
		$file->addNamespace(new PHPNamespace('com\mohiva\framework'));
		$file->addNamespace(new PHPNamespace('com\mohiva\test'));

		$this->assertEquals($expected, $file->generate());
	}

	/**
	 * Test if can generate a file with classes.
	 */
	public function testGenerateFileWithClasses() {

		$file = Bootstrap::$resourceDir . '/manitou/generators/php/file_classes.txt';
		$expected = $this->getFileContent($file);

		$file = new PHPFile();
		$file->addClass(new PHPClass('Test1'));
		$file->addClass(new PHPClass('Test2'));

		$this->assertEquals($expected, $file->generate());
	}

	/**
	 * Test if can generate a file with interfaces.
	 */
	public function testGenerateFileWithInterfaces() {

		$file = Bootstrap::$resourceDir . '/manitou/generators/php/file_interfaces.txt';
		$expected = $this->getFileContent($file);

		$file = new PHPFile();
		$file->addInterface(new PHPInterface('Test1'));
		$file->addInterface(new PHPInterface('Test2'));

		$this->assertEquals($expected, $file->generate());
	}

	/**
	 * Test if can generate a file with classes and interfaces.
	 */
	public function testGenerateFileWithClassesAndInterfaces() {

		$file = Bootstrap::$resourceDir . '/manitou/generators/php/file_classes_interfaces.txt';
		$expected = $this->getFileContent($file);

		$file = new PHPFile();
		$file->addClass(new PHPClass('Test1'));
		$file->addClass(new PHPClass('Test2'));
		$file->addInterface(new PHPInterface('Test1'));
		$file->addInterface(new PHPInterface('Test2'));

		$this->assertEquals($expected, $file->generate());
	}

	/**
	 * Test if can generate a file with a DocBlock.
	 */
	public function testGenerateFileWithDocBlock() {

		$file = Bootstrap::$resourceDir . '/manitou/generators/php/file_docblock.txt';
		$expected = $this->getFileContent($file);

		$file = new PHPFile();
		$file->setDocBlock(new PHPDocBlock());

		$this->assertEquals($expected, $file->generate());
	}

	/**
	 * Test if can generate a file with a DocBlock and classes without a DocBlock.
	 */
	public function testGenerateFileWithDocBlockAndClassesWithoutDocBlock() {

		$file = Bootstrap::$resourceDir . '/manitou/generators/php/file_docblock_classes.txt';
		$expected = $this->getFileContent($file);

		$file = new PHPFile();
		$file->setDocBlock(new PHPDocBlock());
		$file->addClass(new PHPClass('Test1'));
		$file->addClass(new PHPClass('Test2'));

		$this->assertEquals($expected, $file->generate());
	}

	/**
	 * Test if can generate a file with a DocBlock and interfaces without a DocBlock.
	 */
	public function testGenerateFileWithDocBlockAndInterfacesWithoutDocBlock() {

		$file = Bootstrap::$resourceDir . '/manitou/generators/php/file_docblock_interfaces.txt';
		$expected = $this->getFileContent($file);

		$file = new PHPFile();
		$file->setDocBlock(new PHPDocBlock());
		$file->addInterface(new PHPInterface('Test1'));
		$file->addInterface(new PHPInterface('Test2'));

		$this->assertEquals($expected, $file->generate());
	}

	/**
	 * Test if can generate a file with a DocBlock and a class with a DocBlock.
	 */
	public function testGenerateFileWithDocBlockAndClassesDocBlock() {

		$file = Bootstrap::$resourceDir . '/manitou/generators/php/file_docblock_classdocblock.txt';
		$expected = $this->getFileContent($file);

		$file = new PHPFile();
		$file->setDocBlock(new PHPDocBlock());
		$file->addClass((new PHPClass('Test1'))->setDocBlock(new PHPDocBlock()));

		$this->assertEquals($expected, $file->generate());
	}

	/**
	 * Test if can generate a file with a DocBlock, a namespace and class with a DocBlock.
	 */
	public function testGenerateFileWithDocBlockAndNamespaceAndClassesDocBlock() {

		$file = Bootstrap::$resourceDir . '/manitou/generators/php/file_docblock_namespace_classdocblock.txt';
		$expected = $this->getFileContent($file);

		$file = new PHPFile();
		$file->setDocBlock(new PHPDocBlock());
		$file->addNamespace((new PHPNamespace('com\mohiva\framework'))
			->addClass((new PHPClass('Test1'))
				->setDocBlock(new PHPDocBlock())));

		$this->assertEquals($expected, $file->generate());
	}

	/**
	 * Test if the generator throws an exception if a global namespace declaration with
	 * braces is combined with a namespace declaration that uses no braces.
	 *
	 * @expectedException \com\mohiva\manitou\exceptions\WrongNamespaceCombinationException
	 */
	public function testIfThrowsExceptionOnWrongNamespaceCombination() {

		$file = new PHPFile();
		$file->addNamespace((new PHPNamespace())->setBracketed(true));
		$file->addNamespace((new PHPNamespace('com\mohiva\test'))->setBracketed(false));
		$file->generate();
	}

	/**
	 * Test if the generator throws an exception if additionally to a namespace a classes was set.
	 *
	 * @expectedException \com\mohiva\manitou\exceptions\FileGenerationException
	 */
	public function testIfThrowsExceptionOnWrongNamespaceAndClassUsage() {

		$file = new PHPFile();
		$file->addNamespace(new PHPNamespace('com\mohiva\test'));
		$file->addClass(new PHPClass('test'));
		$file->generate();
	}

	/**
	 * Test if the generator throws an exception if additionally to a namespace a interface was set.
	 *
	 * @expectedException \com\mohiva\manitou\exceptions\FileGenerationException
	 */
	public function testIfThrowsExceptionOnWrongNamespaceAndInterfaceUsage() {

		$file = new PHPFile();
		$file->addNamespace(new PHPNamespace('com\mohiva\test'));
		$file->addInterface(new PHPInterface('test'));
		$file->generate();
	}
}
