<?php
use Babel\Babel;

abstract class BaseTests extends PHPUnit_Framework_TestCase
{

	/**
	 * An instance of Babel
	 *
	 * @var Babel
	 */
	protected $babel;

	/**
	 * Bind some classes for testing
	 */
	public function setUp()
	{
		$this->babel = new Babel;
	}

}