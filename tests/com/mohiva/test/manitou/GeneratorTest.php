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
namespace com\mohiva\test\manitou;

use com\mohiva\manitou\Generator;
use com\mohiva\manitou\Config;

/**
 * Unit test case for the Mohiva Manitou project.
 *
 * @category  Mohiva/Manitou
 * @package   Mohiva/Manitou/Test
 * @author    Christian Kaps <christian.kaps@mohiva.com>
 * @copyright Copyright (c) 2007-2012 Christian Kaps (http://www.mohiva.com)
 * @license   https://github.com/mohiva/manitou/blob/master/LICENSE.textile New BSD License
 * @link      https://github.com/mohiva/manitou
 */
class GeneratorTest extends \PHPUnit_Framework_TestCase {

	/**
	 * Tear down the test case.
	 */
	public function tearDown() {

		Generator::setConfig(new Config);
	}

	/**
	 * Test the `setConfig` and `getConfig` methods.
	 */
	public function testConfigAccessors() {

		$config = new Config;

		Generator::setConfig($config);

		$this->assertEquals($config, Generator::getConfig());
	}

	/**
	 * Test if the `__toString` method returns the generated string.
	 */
	public function testToStringReturnsGeneratedString() {

		$string = '$var = 1';

		$generator = $this->getMockForAbstractClass('\com\mohiva\manitou\Generator');
		$generator->expects($this->any())
			->method('generate')
			->will($this->returnValue($string));

		$this->assertEquals($string, (string) $generator);
	}

	/**
	 * Test if the `indent` method doesn't indent the string for level 0.
	 */
	public function testIndentLevel0() {

		/* @var Generator $generator */
		$generator = $this->getMockForAbstractClass('\com\mohiva\manitou\Generator');
		$value = $generator->indent('test', 0);

		$this->assertSame('test', $value);
	}

	/**
	 * Test if the `indent` method indent the string for level 1.
	 */
	public function testIndentLevel1() {

		/* @var Generator $generator */
		$generator = $this->getMockForAbstractClass('\com\mohiva\manitou\Generator');
		$value = $generator->indent('test', 1);

		$this->assertSame(Generator::getConfig()->getIndentString() . 'test', $value);
	}

	/**
	 * Test if the `indent` method indent the string for level 2.
	 */
	public function testIndentLevel2() {

		/* @var Generator $generator */
		$indentString = Generator::getConfig()->getIndentString();
		$generator = $this->getMockForAbstractClass('\com\mohiva\manitou\Generator');
		$value = $generator->indent('test', 2);

		$this->assertSame($indentString . $indentString . 'test', $value);
	}

	/**
	 * Test if the `indent` method indent a multiline string which uses a LF as newline character.
	 */
	public function testMultilineIndentionWithLFCharacter() {

		/* @var Generator $generator */
		$indentString = Generator::getConfig()->getIndentString();
		$generator = $this->getMockForAbstractClass('\com\mohiva\manitou\Generator');
		$value = $generator->indent(
			"test\n" .
			"test\n" .
			"test"
		);

		$this->assertSame(
			$indentString . "test\n" .
			$indentString . "test\n" .
			$indentString . "test",
			$value
		);
	}

	/**
	 * Test if the `indent` method indent a multiline string which uses a CR as newline character.
	 */
	public function testMultilineIndentionWithCRCharacter() {

		/* @var Generator $generator */
		$indentString = Generator::getConfig()->getIndentString();
		$generator = $this->getMockForAbstractClass('\com\mohiva\manitou\Generator');
		$value = $generator->indent(
			"test\r" .
			"test\r" .
			"test"
		);

		$this->assertSame(
			$indentString . "test\r" .
			$indentString . "test\r" .
			$indentString . "test",
			$value
		);
	}

	/**
	 * Test if the `indent` method indent a multiline string which uses a CR LF as newline character.
	 */
	public function testMultilineIndentionWithCRLFCharacter() {

		/* @var Generator $generator */
		$indentString = Generator::getConfig()->getIndentString();
		$generator = $this->getMockForAbstractClass('\com\mohiva\manitou\Generator');
		$value = $generator->indent(
			"test\r\n" .
			"test\r\n" .
			"test"
		);

		$this->assertSame(
			$indentString . "test\r\n" .
			$indentString . "test\r\n" .
			$indentString . "test",
			$value
		);
	}

	/**
	 * Test if the `indent` method indent an empty line.
	 */
	public function testIndentEmptyLine() {

		$config = new Config();
		$config->indentEmptyLines(true);
		Generator::setConfig($config);

		/* @var Generator $generator */
		$indentString = $config->getIndentString();
		$generator = $this->getMockForAbstractClass('\com\mohiva\manitou\Generator');
		$value = $generator->indent('');

		$this->assertSame($indentString, $value);
	}

	/**
	 * Test if the `indent` method doesn't indent an empty line.
	 */
	public function testNotIndentEmptyLine() {

		$config = new Config();
		$config->indentEmptyLines(false);
		Generator::setConfig($config);

		/* @var Generator $generator */
		$generator = $this->getMockForAbstractClass('\com\mohiva\manitou\Generator');
		$value = $generator->indent('');

		$this->assertSame('', $value);
	}
}
