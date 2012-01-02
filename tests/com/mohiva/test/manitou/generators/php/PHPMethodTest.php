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
use com\mohiva\manitou\generators\php\PHPMethod;
use com\mohiva\manitou\generators\php\PHPMember;
use com\mohiva\manitou\generators\php\PHPParameter;
use com\mohiva\manitou\generators\php\PHPDocBlock;
use com\mohiva\manitou\generators\php\PHPRawCode;
use com\mohiva\manitou\generators\php\PHPValue;

/**
 * Unit test case for the `PHPMethod` class.
 * 
 * @category  Mohiva/Manitou
 * @package   Mohiva/Manitou/Test
 * @author    Christian Kaps <christian.kaps@mohiva.com>
 * @copyright Copyright (c) 2007-2012 Christian Kaps (http://www.mohiva.com)
 * @license   https://github.com/mohiva/manitou/blob/master/LICENSE.textile New BSD License
 * @link      https://github.com/mohiva/manitou
 */
class PHPMethodTest extends AbstractGenerator {
	
	/**
	 * Test if can set or get the name of a property.
	 */
	public function testNameAccessors() {
		
		$method = new PHPMethod('__construct');
		
		$this->assertSame('__construct', $method->getName());
		
		$method->setName('__destruct');
		
		$this->assertSame('__destruct', $method->getName());
	}
	
	/**
	 * Test if can set or get the visibility of a method.
	 */
	public function testVisibilityAccessors() {
		
		$method = new PHPMethod('__construct', PHPMember::VISIBILITY_PRIVATE);
		
		$this->assertSame(PHPMember::VISIBILITY_PRIVATE, $method->getVisibility());
		
		$method->setVisibility(PHPMember::VISIBILITY_PROTECTED);
		
		$this->assertSame(PHPMember::VISIBILITY_PROTECTED, $method->getVisibility());
	}
	
	/**
	 * Test if can set or get the scope of a constant.
	 */
	public function testScopeAccessors() {
		
		$method = new PHPMethod('__construct', PHPMember::VISIBILITY_PUBLIC, PHPMethod::SCOPE_INTERFACE);
		
		$this->assertSame(PHPMethod::SCOPE_INTERFACE, $method->getScope());
		
		$method->setScope(PHPMethod::SCOPE_CLASS);
		
		$this->assertSame(PHPMethod::SCOPE_CLASS, $method->getScope());
	}
	
	/**
	 * Test if can set or get the abstract property of the method.
	 */
	public function testIsAbstractAccessors() {
		
		$method = new PHPMethod(
			'__construct',
			PHPMember::VISIBILITY_PUBLIC,
			PHPMethod::SCOPE_CLASS,
			true
		);
		
		$this->assertTrue($method->isAbstract());
		
		$method->setAbstract(false);
		
		$this->assertFalse($method->isAbstract());
	}
	
	/**
	 * Test if can set or get the final property of a method.
	 */
	public function testIsFinalAccessors() {
		
		$method = new PHPMethod(
			'__construct',
			PHPMember::VISIBILITY_PUBLIC,
			PHPMethod::SCOPE_CLASS,
			false,
			true
		);
		
		$this->assertTrue($method->isFinal());
		
		$method->setFinal(false);
		
		$this->assertFalse($method->isFinal());
	}
	
	/**
	 * Test if can set or get the static property of a method.
	 */
	public function testIsStaticAccessors() {
		
		$method = new PHPMethod(
			'__construct',
			PHPMember::VISIBILITY_PUBLIC,
			PHPMethod::SCOPE_CLASS,
			false,
			false,
			true
		);
		
		$this->assertTrue($method->isStatic());
		
		$method->setStatic(false);
		
		$this->assertFalse($method->isStatic());
	}
	
	/**
	 * Test if can set or get parameters.
	 */
	public function testParametersAccessors() {
		
		$param1 = new PHPParameter('index');
		$param2 = new PHPParameter('keyword');
		$expected = array(
			spl_object_hash($param1) => $param1,
			spl_object_hash($param2) => $param2
		);
		
		$method = new PHPMethod('__construct');
		$method->setParameters($expected);
		
		$this->assertEquals($expected, $method->getParameters());
	}
	
	/**
	 * Test if can add multiple parameters.
	 */
	public function testAddParameters() {
		
		$param1 = new PHPParameter('index');
		$param2 = new PHPParameter('keyword');
		$expected = array(
			spl_object_hash($param1) => $param1,
			spl_object_hash($param2) => $param2
		);
		
		$method = new PHPMethod('__construct');
		$method->addParameter($param1);
		$method->addParameter($param2);
		
		$this->assertEquals($expected, $method->getParameters());
	}
	
	/**
	 * Test if can remove multiple parameters.
	 */
	public function testRemoveParameters() {
		
		$param1 = new PHPParameter('index');
		$param2 = new PHPParameter('keyword');
		
		$method = new PHPMethod('__construct');
		$method->addParameter($param1);
		$method->addParameter($param2);
		$method->removeParameter($param1);
		$method->removeParameter($param2);
		
		$this->assertEquals(array(), $method->getParameters());
	}
	
	/**
	 * Test if can set or get a DocBlock object.
	 */
	public function testDocBlockAccessors() {
		
		$method = new PHPMethod('__construct');
		$method->setDocBlock(new PHPDocBlock());
		
		$this->assertInstanceOf('com\mohiva\manitou\generators\php\PHPDocBlock', $method->getDocBlock());
	}
	
	/**
	 * Test if can set or get the body of the method.
	 */
	public function testBodyAccessors() {
		
		$method = new PHPMethod('__construct');
		$method->setBody(new PHPRawCode());
		
		$this->assertInstanceOf('com\mohiva\manitou\generators\php\PHPRawCode', $method->getBody());
	}
	
	/**
	 * Test if can generate a public class method.
	 */
	public function testGeneratePublicClassMethod() {
		
		$file = Bootstrap::$resourceDir . '/manitou/generators/php/method_class_public.txt';
		$expected = $this->getFileContent($file);
		
		$method = new PHPMethod('test');
		$method->setVisibility(PHPMember::VISIBILITY_PUBLIC);
		
		$this->assertEquals($expected, $method->generate());
	}
	
	/**
	 * Test if can generate a protected class method.
	 */
	public function testGenerateProtectedClassMethod() {
		
		$file = Bootstrap::$resourceDir . '/manitou/generators/php/method_class_protected.txt';
		$expected = $this->getFileContent($file);
		
		$method = new PHPMethod('test');
		$method->setVisibility(PHPMember::VISIBILITY_PROTECTED);
		
		$this->assertEquals($expected, $method->generate());
	}
	
	/**
	 * Test if can generate a private class method.
	 */
	public function testGeneratePrivateClassMethod() {
		
		$file = Bootstrap::$resourceDir . '/manitou/generators/php/method_class_private.txt';
		$expected = $this->getFileContent($file);
		
		$method = new PHPMethod('test');
		$method->setVisibility(PHPMember::VISIBILITY_PRIVATE);
		
		$this->assertEquals($expected, $method->generate());
	}
	
	/**
	 * Test if can generate a public interface method.
	 */
	public function testGeneratePublicInterfaceMethod() {
		
		$file = Bootstrap::$resourceDir . '/manitou/generators/php/method_interface_public.txt';
		$expected = $this->getFileContent($file);
		
		$method = new PHPMethod('test');
		$method->setScope(PHPMethod::SCOPE_INTERFACE);
		$method->setVisibility(PHPMember::VISIBILITY_PUBLIC);
		
		$this->assertEquals($expected, $method->generate());
	}
	
	/**
	 * Test if can generate a protected interface method.
	 */
	public function testGenerateProtectedInterfaceMethod() {
		
		$file = Bootstrap::$resourceDir . '/manitou/generators/php/method_interface_protected.txt';
		$expected = $this->getFileContent($file);
		
		$method = new PHPMethod('test');
		$method->setScope(PHPMethod::SCOPE_INTERFACE);
		$method->setVisibility(PHPMember::VISIBILITY_PROTECTED);
		
		$this->assertEquals($expected, $method->generate());
	}
	
	/**
	 * Test if can generate a private interface method.
	 */
	public function testGeneratePrivateInterfaceMethod() {
		
		$file = Bootstrap::$resourceDir . '/manitou/generators/php/method_interface_private.txt';
		$expected = $this->getFileContent($file);
		
		$method = new PHPMethod('test');
		$method->setScope(PHPMethod::SCOPE_INTERFACE);
		$method->setVisibility(PHPMember::VISIBILITY_PRIVATE);
		
		$this->assertEquals($expected, $method->generate());
	}
	
	/**
	 * Test if can generate a abstract class method.
	 */
	public function testGenerateAbstractClassMethod() {
		
		$file = Bootstrap::$resourceDir . '/manitou/generators/php/method_class_abstract.txt';
		$expected = $this->getFileContent($file);
		
		$method = new PHPMethod('test');
		$method->setAbstract(true);
		
		$this->assertEquals($expected, $method->generate());
	}
	
	/**
	 * Test if can generate a final class method.
	 */
	public function testGenerateFinalClassMethod() {
		
		$file = Bootstrap::$resourceDir . '/manitou/generators/php/method_class_final.txt';
		$expected = $this->getFileContent($file);
		
		$method = new PHPMethod('test');
		$method->setFinal(true);
		
		$this->assertEquals($expected, $method->generate());
	}
	
	/**
	 * Test if can generate a static class method.
	 */
	public function testGenerateStaticClassMethod() {
		
		$file = Bootstrap::$resourceDir . '/manitou/generators/php/method_class_static.txt';
		$expected = $this->getFileContent($file);
		
		$method = new PHPMethod('test');
		$method->setStatic(true);
		
		$this->assertEquals($expected, $method->generate());
	}
	
	/**
	 * Test if can generate a final static class method.
	 */
	public function testGenerateFinalStaticClassMethod() {
		
		$file = Bootstrap::$resourceDir . '/manitou/generators/php/method_class_final_static.txt';
		$expected = $this->getFileContent($file);
		
		$method = new PHPMethod('test');
		$method->setFinal(true);
		$method->setStatic(true);
		
		$this->assertEquals($expected, $method->generate());
	}
	
	/**
	 * Test if can generate a static interface method.
	 */
	public function testGenerateStaticInterfaceMethod() {
		
		$file = Bootstrap::$resourceDir . '/manitou/generators/php/method_interface_static.txt';
		$expected = $this->getFileContent($file);
		
		$method = new PHPMethod('test');
		$method->setScope(PHPMethod::SCOPE_INTERFACE);
		$method->setStatic(true);
		
		$this->assertEquals($expected, $method->generate());
	}
	
	/**
	 * Test if can generate a class method with one parameter.
	 */
	public function testGenerateClassMethodWithOneParameter() {
		
		$file = Bootstrap::$resourceDir . '/manitou/generators/php/method_class_one_parameter.txt';
		$expected = $this->getFileContent($file);
		
		$method = new PHPMethod('test');
		$method->addParameter(new PHPParameter('value', 'string', new PHPValue('test')));
		
		$this->assertEquals($expected, $method->generate());
	}
	
	/**
	 * Test if can generate a class method with multiple parameters.
	 */
	public function testGenerateClassMethodWithMultipleParameters() {
		
		$file = Bootstrap::$resourceDir . '/manitou/generators/php/method_class_multiple_parameters.txt';
		$expected = $this->getFileContent($file);
		
		$method = new PHPMethod('test');
		$method->addParameter(new PHPParameter('name'));
		$method->addParameter(new PHPParameter('value', 'string', new PHPValue('test')));
		$method->addParameter(new PHPParameter('index', 'int', new PHPValue(1)));
		
		$this->assertEquals($expected, $method->generate());
	}
	
	/**
	 * Test if can generate an interface method with one parameter.
	 */
	public function testGenerateInterfaceMethodWithOneParameter() {
		
		$file = Bootstrap::$resourceDir . '/manitou/generators/php/method_interface_one_parameter.txt';
		$expected = $this->getFileContent($file);
		
		$method = new PHPMethod('test');
		$method->setScope(PHPMethod::SCOPE_INTERFACE);
		$method->addParameter(new PHPParameter('value', 'string', new PHPValue('test')));
		
		$this->assertEquals($expected, $method->generate());
	}
	
	/**
	 * Test if can generate an interface method with multiple parameters.
	 */
	public function testGenerateInterfaceMethodWithMultipleParameters() {
		
		$file = Bootstrap::$resourceDir . '/manitou/generators/php/method_interface_multiple_parameters.txt';
		$expected = $this->getFileContent($file);
		
		$method = new PHPMethod('test');
		$method->setScope(PHPMethod::SCOPE_INTERFACE);
		$method->addParameter(new PHPParameter('name'));
		$method->addParameter(new PHPParameter('value', 'string', new PHPValue('test')));
		$method->addParameter(new PHPParameter('index', 'int', new PHPValue(1)));
		
		$this->assertEquals($expected, $method->generate());
	}
	
	/**
	 * Test if can generate a class method with body.
	 */
	public function testGenerateClassMethodWithBody() {
		
		$file = Bootstrap::$resourceDir . '/manitou/generators/php/method_class_body.txt';
		$expected = $this->getFileContent($file);
		
		$body = new PHPRawCode();
		$body->openScope('for ($i = 0; $i < 10; $i++) {');
		$body->addLine('echo $i;');
		$body->closeScope('}');
		$body->addLine();
		$body->addLine('return true;');
		
		$method = new PHPMethod('test');
		$method->setBody($body);
		
		$this->assertEquals($expected, $method->generate());
	}
	
	/**
	 * Test if can generate a class method with a DocBlock.
	 */
	public function testGenerateClassMethodWithDocBlock() {
		
		$file = Bootstrap::$resourceDir . '/manitou/generators/php/method_class_docblock.txt';
		$expected = $this->getFileContent($file);
		
		$method = new PHPMethod('test');
		$method->setDocBlock(new PHPDocBlock());
		
		$this->assertEquals($expected, $method->generate());
	}
	
	/**
	 * Test if can generate an interface method with a DocBlock.
	 */
	public function testGenerateInterfaceMethodWithDocBlock() {
		
		$file = Bootstrap::$resourceDir . '/manitou/generators/php/method_interface_docblock.txt';
		$expected = $this->getFileContent($file);
		
		$method = new PHPMethod('test');
		$method->setScope(PHPMethod::SCOPE_INTERFACE);
		$method->setDocBlock(new PHPDocBlock());
		
		$this->assertEquals($expected, $method->generate());
	}
	
	/**
	 * Test if throws an exception if the class method is declared as abstract and as final.
	 * 
	 * @expectedException \com\mohiva\manitou\exceptions\FinalAbstractClassMethodException
	 */
	public function testExceptionForAbstractFinalClassMethod() {
		
		$method = new PHPMethod('__construct');
		$method->setAbstract(true);
		$method->setFinal(true);
		$method->generate();
	}
	
	/**
	 * Test if throws an exception if the class method is declared as abstract and as static.
	 * 
	 * @expectedException \com\mohiva\manitou\exceptions\StaticAbstractClassMethodException
	 */
	public function testExceptionForAbstractStaticClassMethod() {
		
		$method = new PHPMethod('__construct');
		$method->setAbstract(true);
		$method->setStatic(true);
		$method->generate();
	}
	
	/**
	 * Test if throws an exception if an abstract class method contains body.
	 * 
	 * @expectedException \com\mohiva\manitou\exceptions\AbstractClassMethodContainsBodyException
	 */
	public function testExceptionForAbstractClassMethodWhichContainsBody() {
		
		$method = new PHPMethod('__construct');
		$method->setAbstract(true);
		$method->setBody(new PHPRawCode());
		$method->generate();
	}
	
	/**
	 * Test if throws an exception if the interface method is declared as abstract.
	 * 
	 * @expectedException \com\mohiva\manitou\exceptions\AbstractInterfaceMethodException
	 */
	public function testExceptionForAbstractInterfaceMethod() {
		
		$method = new PHPMethod('__construct');
		$method->setScope(PHPMethod::SCOPE_INTERFACE);
		$method->setAbstract(true);
		$method->generate();
	}
	
	/**
	 * Test if throws an exception if the interface method is declared as final.
	 * 
	 * @expectedException \com\mohiva\manitou\exceptions\FinalInterfaceMethodException
	 */
	public function testExceptionForFinalInterfaceMethod() {
		
		$method = new PHPMethod('__construct');
		$method->setScope(PHPMethod::SCOPE_INTERFACE);
		$method->setFinal(true);
		$method->generate();
	}
	
	/**
	 * Test if throws an exception if an interface method contains body.
	 * 
	 * @expectedException \com\mohiva\manitou\exceptions\InterfaceMethodContainsBodyException
	 */
	public function testExceptionForInterfaceMethodWhichContainsBody() {
		
		$method = new PHPMethod('__construct');
		$method->setScope(PHPMethod::SCOPE_INTERFACE);
		$method->setBody(new PHPRawCode());
		$method->generate();
	}
	
	/**
	 * Test if throws an exception if the visibility is unexpected.
	 * 
	 * @expectedException \com\mohiva\manitou\exceptions\UnexpectedVisibilityException
	 */
	public function testExceptionForUnexpectedVisibility() {
		
		$method = new PHPMethod('__construct');
		$method->setVisibility(4);
		$method->generate();
	}
	
	/**
	 * Test if throws an exception if the scope is unexpected.
	 * 
	 * @expectedException \com\mohiva\manitou\exceptions\UnexpectedScopeException
	 */
	public function testExceptionForUnexpectedScope() {
		
		$method = new PHPMethod('__construct');
		$method->setScope(3);
		$method->generate();
	}
}
