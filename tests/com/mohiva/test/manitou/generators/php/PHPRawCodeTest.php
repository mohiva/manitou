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
use com\mohiva\manitou\Generator;
use com\mohiva\manitou\generators\php\PHPRawCode;

/**
 * Unit test case for the `PHPRawCode` class.
 * 
 * @category  Mohiva/Manitou
 * @package   Mohiva/Manitou/Test
 * @author    Christian Kaps <christian.kaps@mohiva.com>
 * @copyright Copyright (c) 2007-2012 Christian Kaps (http://www.mohiva.com)
 * @license   https://github.com/mohiva/manitou/blob/master/LICENSE.textile New BSD License
 * @link      https://github.com/mohiva/manitou
 */
class PHPRawCodeTest extends AbstractGenerator {
	
	/**
	 * Test if can set or get code.
	 */
	public function testCodeAccessors() {
		
		$code = new PHPRawCode;
		$code->setCode("echo 'test';");
		
		$this->assertSame("echo 'test';", $code->getCode());
	}
	
	/**
	 * Test if can add a code fragment to non existing code.
	 */
	public function testAddCodeToNonExistingCode() {
		
		$expected = 'exit();';
		
		$code = new PHPRawCode;
		$code->addCode('exit();');
		
		$this->assertSame($expected, $code->getCode());
	}
	
	/**
	 * Test if can add a code fragment to existing code.
	 */
	public function testAddCodeToExistingCode() {
		
		$expected  = "echo 'test';" . Generator::LINE_FEED;
		$expected .= 'exit();';
		
		$code = new PHPRawCode;
		$code->setCode("echo 'test';");
		$code->addCode(Generator::LINE_FEED . 'exit();');
		
		$this->assertSame($expected, $code->getCode());
	}
	
	/**
	 * Test if can set or get the indention level.
	 */
	public function testIndentLevelAccessors() {
		
		$code = new PHPRawCode;
		$code->setIndentLevel(2);
		
		$this->assertSame(2, $code->getIndentLevel());
	}
	
	/**
	 * Test if can add a new line to non existing code.
	 */
	public function testAddLineToNonExistingCode() {
		
		$expected = 'exit();';
		
		$code = new PHPRawCode;
		$code->addLine('exit();');
		
		$this->assertSame($expected, $code->getCode());
	}
	
	/**
	 * Test if can add a new line to existing code.
	 */
	public function testAddLineToExistingCode() {
		
		$expected  = "echo 'test';" . Generator::LINE_FEED;
		$expected .= 'exit();';
		
		$code = new PHPRawCode;
		$code->setCode("echo 'test';");
		$code->addLine('exit();');
		
		$this->assertSame($expected, $code->getCode());
	}
	
	/**
	 * Test if can generate raw code.
	 */
	public function testGenerateRawCode() {
		
		$file = Bootstrap::$resourceDir . '/manitou/generators/php/rawcode.txt';
		$expected = $this->getFileContent($file);
		
		$code = new PHPRawCode;
		$code->setCode('<?php');
		$code->addLine();
		$code->openScope('class Test extends AbstractTest {');
		$code->addLine();
		$code->addLine('private $rows = 10;');
		$code->addLine();
		$code->openScope('public function __construct() {');
		$code->addLine();
		$code->openScope('for ($i = 0; $i < $this->rows; $i++) {');
		$code->addLine('echo $i;');
		$code->closeScope('}');
		$code->addLine();
		$code->openScope('if (true) {');
		$code->addLine();
		$code->openScope('} else if (false) {', true);
		$code->addLine();
		$code->closeScope('} else {', true);
		$code->addLine();		
		$code->closeScope('}');
		$code->closeScope('}');
		$code->closeScope('}');
		
		$this->assertEquals($expected, $code->generate());
	}
}
