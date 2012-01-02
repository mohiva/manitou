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

/**
 * Test suite for the Mohiva Manitou project.
 * 
 * @category  Mohiva
 * @package   Mohiva/Test
 * @author    Christian Kaps <akkie@framework.mohiva.com>
 * @copyright Copyright (c) 2007-2011 Christian Kaps (http://www.mohiva.com)
 * @license   http://framework.mohiva.com/license New BSD License
 * @link      http://framework.mohiva.com
 */
class AllTests extends \PHPUnit_Framework_TestSuite {
	
	/**
	 * Constructs the test suite handler.
	 */
	public function __construct() {
		
		$this->setName(__CLASS__);
		$this->addTestSuite(__NAMESPACE__ . '\PHPFileTest');
		$this->addTestSuite(__NAMESPACE__ . '\PHPNamespaceTest');
		$this->addTestSuite(__NAMESPACE__ . '\PHPUseTest');
		$this->addTestSuite(__NAMESPACE__ . '\PHPClassTest');
		$this->addTestSuite(__NAMESPACE__ . '\PHPInterfaceTest');
		$this->addTestSuite(__NAMESPACE__ . '\PHPValueTest');
		$this->addTestSuite(__NAMESPACE__ . '\PHPConstantTest');
		$this->addTestSuite(__NAMESPACE__ . '\PHPMethodTest');
		$this->addTestSuite(__NAMESPACE__ . '\PHPPropertyTest');
		$this->addTestSuite(__NAMESPACE__ . '\PHPParameterTest');
		$this->addTestSuite(__NAMESPACE__ . '\PHPDocBlockTest');
		$this->addTestSuite(__NAMESPACE__ . '\PHPRawCodeTest');
	}
	
	/**
	 * Creates the suite.
	 * 
	 * @return AllTests The test suite.
	 */
	public static function suite() {
		
		return new self();
	}
}
