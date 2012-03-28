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
use com\mohiva\manitou\Generator;
use com\mohiva\manitou\generators\php\PHPDocBlock;
use com\mohiva\test\manitou\AbstractGenerator;

/**
 * Unit test case for the `PHPDocBlock` class.
 *
 * @category  Mohiva/Manitou
 * @package   Mohiva/Manitou/Test
 * @author    Christian Kaps <christian.kaps@mohiva.com>
 * @copyright Copyright (c) 2007-2012 Christian Kaps (http://www.mohiva.com)
 * @license   https://github.com/mohiva/manitou/blob/master/LICENSE.textile New BSD License
 * @link      https://github.com/mohiva/manitou
 */
class PHPDocBlockTest extends AbstractGenerator {

	/**
	 * Test the `setSections` and `getSections` accessors.
	 */
	public function testSectionAccessors() {

		$section1 = sha1(microtime(true));
		$section2 = sha1(microtime(true));
		$sections = array(
			sha1($section1) => $section1,
			sha1($section2) => $section2
		);

		$docBlock = new PHPDocBlock;
		$docBlock->setSections($sections);

		$this->assertSame($sections, $docBlock->getSections());
	}

	/**
	 * Test if can add multiple sections.
	 */
	public function testAddSection() {

		$section1 = sha1(microtime(true));
		$section2 = sha1(microtime(true));
		$expected = array(
			sha1($section1) => $section1,
			sha1($section2) => $section2
		);

		$docBlock = new PHPDocBlock;
		$docBlock->addSection($section1);
		$docBlock->addSection($section2);

		$this->assertSame($expected, $docBlock->getSections());
	}

	/**
	 * Test if can remove multiple sections.
	 */
	public function testRemoveSection() {

		$section1 = sha1(microtime(true));
		$section2 = sha1(microtime(true));

		$docBlock = new PHPDocBlock;
		$docBlock->addSection($section1);
		$docBlock->addSection($section2);
		$docBlock->removeSection($section1);
		$docBlock->removeSection($section2);

		$this->assertSame(array(), $docBlock->getSections());
	}

	/**
	 * Test the `setAnnotations` and `getAnnotations` accessors.
	 */
	public function testAnnotationAccessors() {

		$annotation1 = sha1(microtime(true));
		$annotation2 = sha1(microtime(true));
		$annotations = array(
			sha1($annotation1) => $annotation1,
			sha1($annotation2) => $annotation2
		);

		$docBlock = new PHPDocBlock;
		$docBlock->setAnnotations($annotations);

		$this->assertSame($annotations, $docBlock->getAnnotations());
	}

	/**
	 * Test if can add multiple annotations.
	 */
	public function testAddAnnotation() {

		$annotation1 = sha1(microtime(true));
		$annotation2 = sha1(microtime(true));
		$expected = array(
			sha1($annotation1) => $annotation1,
			sha1($annotation2) => $annotation2
		);

		$docBlock = new PHPDocBlock;
		$docBlock->addAnnotation($annotation1);
		$docBlock->addAnnotation($annotation2);

		$this->assertSame($expected, $docBlock->getAnnotations());
	}

	/**
	 * Test if can remove multiple annotations.
	 */
	public function testRemoveAnnotation() {

		$annotation1 = sha1(microtime(true));
		$annotation2 = sha1(microtime(true));
		$docBlock = new PHPDocBlock;
		$docBlock->addAnnotation($annotation1);
		$docBlock->addAnnotation($annotation2);
		$docBlock->removeAnnotation($annotation1);
		$docBlock->removeAnnotation($annotation2);

		$this->assertSame(array(), $docBlock->getSections());
	}

	/**
	 * Test if can generate an empty DocBlock.
	 */
	public function testGenerateEmptyDocBlock() {

		$file = Bootstrap::$resourceDir . '/manitou/generators/php/docblock.txt';
		$expected = $this->getFileContent($file);

		$docBlock = new PHPDocBlock;

		$this->assertEquals($expected, $docBlock->generate());
	}

	/**
	 * Test if can generate a DocBlock with a single section.
	 */
	public function testGenerateSingleSection() {

		$file = Bootstrap::$resourceDir . '/manitou/generators/php/docblock_single_section.txt';
		$expected = $this->getFileContent($file);

		$docBlock = new PHPDocBlock;
		$docBlock->addSection('Short comment.');

		$this->assertEquals($expected, $docBlock->generate());
	}

	/**
	 * Test if can generate a DocBlock with multiple sections.
	 */
	public function testGenerateMultipleSections() {

		$longComment  = 'Lorem ipsum ad qui diam putant corpora, rebum primis id vim. Admodum fuisset mei et. ';
		$longComment .= 'Per ne molestiae posidonium. Nec ad natum homero delectus. Qui eu facilis lobortis, ';
		$longComment .= 'nam rebum utroque vocibus at.';

		$file = Bootstrap::$resourceDir . '/manitou/generators/php/docblock_multiple_sections.txt';
		$expected = $this->getFileContent($file);

		$docBlock = new PHPDocBlock;
		$docBlock->addSection('Short comment.');
		$docBlock->addSection($longComment);

		$this->assertEquals($expected, $docBlock->generate());
	}

	/**
	 * Test if can generate a DocBlock with a single annotation.
	 */
	public function testGenerateSingleAnnotation() {

		$file = Bootstrap::$resourceDir . '/manitou/generators/php/docblock_single_annotation.txt';
		$expected = $this->getFileContent($file);

		$docBlock = new PHPDocBlock;
		$docBlock->addAnnotation('@param string $string A string.');

		$this->assertEquals($expected, $docBlock->generate());
	}

	/**
	 * Test if can generate a DocBlock with multiple annotations.
	 */
	public function testGenerateMultipleAnnotations() {

		$file = Bootstrap::$resourceDir . '/manitou/generators/php/docblock_multiple_annotations.txt';
		$expected = $this->getFileContent($file);

		$docBlock = new PHPDocBlock;
		$docBlock->addAnnotation('@param string $string A string.');
		$docBlock->addAnnotation('@return string A string.');

		$this->assertEquals($expected, $docBlock->generate());
	}

	/**
	 * Test if can generate a complex comment.
	 */
	public function testGenerateComplexComment() {

		$lineFeed = Generator::getConfig()->getNewline();
		$license  = 'This source file is subject to the new BSD license that is bundled' . $lineFeed;
		$license .= 'with this package in the file LICENSE.txt.' . $lineFeed;
		$license .= 'It is also available through the world-wide-web at this URL:' . $lineFeed;
		$license .= 'http://framework.mohiva.com/license' . $lineFeed;
		$license .= 'If you did not receive a copy of the license and are unable to' . $lineFeed;
		$license .= 'obtain it through the world-wide-web, please send an email' . $lineFeed;
		$license .= 'to license@framework.mohiva.com so we can send you a copy immediately.' . $lineFeed;

		$file = Bootstrap::$resourceDir . '/manitou/generators/php/docblock_complex.txt';
		$expected = $this->getFileContent($file);

		$docBlock = new PHPDocBlock;
		$docBlock->addSection('Unit test case for the Mohiva `PHPDocBlock` class.');
		$docBlock->addSection('LICENSE');
		$docBlock->addSection($license);
		$docBlock->addAnnotation('@category  Mohiva');
		$docBlock->addAnnotation('@package   Mohiva/Test');
		$docBlock->addAnnotation('@author    Christian Kaps <akkie@framework.mohiva.com>');
		$docBlock->addAnnotation('@copyright Copyright (c) 2007-2011 Christian Kaps (http://www.mohiva.com)');
		$docBlock->addAnnotation('@license   http://framework.mohiva.com/license New BSD License');
		$docBlock->addAnnotation('@link      http://framework.mohiva.com');

		$this->assertEquals($expected, $docBlock->generate());
	}
}
