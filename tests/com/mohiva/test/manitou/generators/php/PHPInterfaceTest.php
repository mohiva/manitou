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
	 * Test if can set or get the name of an interface.
	 */
	public function testNameAccessors() {
		
		$interface = new PHPInterface('Test1');
		
		$this->assertSame('Test1', $interface->getName());
		
		$interface->setName('Test2');
		
		$this->assertSame('Test2', $interface->getName());
	}
	
	/**
	 * Test if can set or get the parent interfaces list.
	 */
	public function testParentInterfacesAccessors() {
		
		$expected1 = array(sha1('Countable') => 'Countable');
		$expected2 = array(sha1('OuterIterator') => 'OuterIterator');
		
		$interface = new PHPInterface('Test', array('Countable'));
		
		$this->assertSame($expected1, $interface->getParentInterfaces());
		
		$interface->setParentInterfaces(array('OuterIterator'));
		
		$this->assertSame($expected2, $interface->getParentInterfaces());
	}
	
	/**
	 * Test if can add multiple parent interfaces.
	 */
	public function testAddParentInterface() {
		
		$expected = array(
			sha1('Countable') => 'Countable',
			sha1('OuterIterator') => 'OuterIterator'
		);
		
		$interface = new PHPInterface('Test');
		$interface->addParentInterface('Countable');
		$interface->addParentInterface('OuterIterator');
		
		$this->assertSame($expected, $interface->getParentInterfaces());
	}
	
	/**
	 * Test if can remove multiple parent interfaces.
	 */
	public function testRemoveParentInterface() {
		
		$interface = new PHPInterface('Test');
		$interface->addParentInterface('Countable');
		$interface->addParentInterface('OuterIterator');
		$interface->removeParentInterface('Countable');
		$interface->removeParentInterface('OuterIterator');
		
		$this->assertSame(array(), $interface->getParentInterfaces());
	}
	
	/**
	 * Test if can set or get a DocBlock object.
	 */
	public function testDocBlockAccessors() {
		
		$interface = new PHPInterface('Test');
		$interface->setDocBlock(new PHPDocBlock());
		
		$this->assertInstanceOf('com\mohiva\manitou\generators\php\PHPDocBlock', $interface->getDocBlock());
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
		
		$this->assertEquals($expected, PHPInterface::create('Test')
			->setParentInterfaces(array('Serializable', 'Countable'))
			->setDocBlock(PHPDocBlock::create()->addSection('A complex interface example.'))
			->addConstant(PHPConstant::create('TYPE_HTTP', new PHPValue(1))->setDocBlock(new PHPDocBlock()))
			->addConstant(PHPConstant::create('TYPE_CLI', new PHPValue(2))->setDocBlock(new PHPDocBlock()))
			->addMethod(PHPMethod::create('__construct')
				->setScope(PHPMethod::SCOPE_INTERFACE)
				->addParameter(new PHPParameter('type'))
				->setDocBlock(PHPDocBlock::create()->addSection('The class constructor.')))
			->generate()
		);
	}
}
