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
 * @package   Mohiva/Manitou/Exceptions
 * @author    Christian Kaps <christian.kaps@mohiva.com>
 * @copyright Copyright (c) 2007-2012 Christian Kaps (http://www.mohiva.com)
 * @license   https://github.com/mohiva/manitou/blob/master/LICENSE.textile New BSD License
 * @link      https://github.com/mohiva/manitou
 */
namespace com\mohiva\manitou\generators\php;

use com\mohiva\manitou\Generator;

/**
 * Generates the DocBlock for a file, class, constant, property or  method.
 *
 * @category  Mohiva/Manitou
 * @package   Mohiva/Manitou/Exceptions
 * @author    Christian Kaps <christian.kaps@mohiva.com>
 * @copyright Copyright (c) 2007-2012 Christian Kaps (http://www.mohiva.com)
 * @license   https://github.com/mohiva/manitou/blob/master/LICENSE.textile New BSD License
 * @link      https://github.com/mohiva/manitou
 */
class PHPDocBlock extends Generator {

	/**
	 * The max width of a section.
	 *
	 * @var int
	 */
	const SECTION_WIDTH = 75;

	/**
	 * A list with sections.
	 *
	 * @var array
	 */
	protected $sections = array();

	/**
	 * A list with annotations.
	 *
	 * @var array
	 */
	protected $annotations = array();

	/**
	 * Create an instance of this class and return it. This method
	 * exists to provide a fluent interface.
	 *
	 * @return PHPDocBlock An instance of this class.
	 */
	public static function create() {

		$instance = new self();

		return $instance;
	}

	/**
	 * Sets a list with sections.
	 *
	 * @param array $sections A list with sections.
	 * @return PHPDocBlock This object instance to provide a fluent interface.
	 */
	public function setSections(array $sections) {

		$this->sections = array();
		foreach ($sections as $section) {
			$this->addSection($section);
		}

		return $this;
	}

	/**
	 * Gets the list with sections defined for this DocBlock comment.
	 *
	 * @return array A list with sections defined for this DocBlock comment.
	 */
	public function getSections() {

		return $this->sections;
	}

	/**
	 * Add a new section to the comment.
	 *
	 * @param string $section The section to add.
	 * @return PHPDocBlock This object instance to provide a fluent interface.
	 */
	public function addSection($section) {

		$this->sections[sha1($section)] = $section;

		return $this;
	}

	/**
	 * Remove a section from comment.
	 *
	 * @param string $section The section to remove.
	 * @return PHPDocBlock This object instance to provide a fluent interface.
	 */
	public function removeSection($section) {

		$id = sha1($section);
		if (isset($this->sections[$id])) {
			unset($this->sections[$id]);
		}

		return $this;
	}

	/**
	 * Sets a list with annotations.
	 *
	 * @param array $annotations A list with annotations.
	 * @return PHPDocBlock This object instance to provide a fluent interface.
	 */
	public function setAnnotations(array $annotations) {

		$this->annotations = array();
		foreach ($annotations as $annotation) {
			$this->addAnnotation($annotation);
		}

		return $this;
	}

	/**
	 * Gets the list with annotations defined for this DocBlock comment.
	 *
	 * @return array A list with annotations defined for this DocBlock comment.
	 */
	public function getAnnotations() {

		return $this->annotations;
	}

	/**
	 * Add a new annotation to the DocBlock comment.
	 *
	 * @param string $annotation The annotation to add.
	 * @return PHPDocBlock This object instance to provide a fluent interface.
	 */
	public function addAnnotation($annotation) {

		$this->annotations[sha1($annotation)] = $annotation;

		return $this;
	}

	/**
	 * Remove a annotation from DocBlock comment.
	 *
	 * @param string $annotation The annotation to remove.
	 * @return PHPDocBlock This object instance to provide a fluent interface.
	 */
	public function removeAnnotation($annotation) {

		$id = sha1($annotation);
		if (isset($this->annotations[$id])) {
			unset($this->annotations[$id]);
		}

		return $this;
	}

	/**
	 * Generate a DocBlock comment and return it.
	 *
	 * @return string The generated DocBlock comment.
	 */
	public function generate() {

		$lineFeed = self::getConfig()->getNewline();
		$code  = '/**' . $lineFeed;
		$code .= $this->generateSections();
		$code .= $this->sections && $this->annotations ? ' *' . $lineFeed : '';
		$code .= $this->generateAnnotations();
		$code .= !$this->sections && !$this->annotations ? ' *' . $lineFeed : '';
		$code .= ' */' . $lineFeed;

		return $code;
	}

	/**
	 * Generate the sections part of this DocBlock comment.
	 *
	 * @return string The content of all set sections or an empty string if no sections are set.
	 */
	public function generateSections() {

		if (!$this->sections) {
			return '';
		}

		$first = true;
		$code = '';
		$lineFeed = self::getConfig()->getNewline();
		foreach ($this->sections as $section) {
			if (!$first) {
				$code .= ' *' . $lineFeed;
			}

			$first = false;
			$lines = explode($lineFeed, trim($section, $lineFeed));

			// Wrap long lines without a newline character
			if (count($lines) == 1) {
				$code .= ' * ' . wordwrap($section, self::SECTION_WIDTH, $lineFeed . ' * ') . $lineFeed;
				continue;
			}

			// Build lines
			foreach ($lines as $line) {
				$code .= ' * ' . $line . $lineFeed;
			}
		}

		return $code;
	}

	/**
	 * Generate the annotations part of this DocBlock comment.
	 *
	 * @return string The content of all set annotations or an empty string if no annotations are set.
	 */
	public function generateAnnotations() {

		if (!$this->annotations) {
			return '';
		}

		$code = '';
		$lineFeed = self::getConfig()->getNewline();
		foreach ($this->annotations as $annotation) {
			$code .= ' * ' . $annotation . $lineFeed;
		}

		return $code;
	}
}
