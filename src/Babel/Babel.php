<?php
namespace Babel;

use Underscore\Methods\StringMethods as String;
use Illuminate\Container\Container;

class Babel
{

	/**
	 * The Container
	 *
	 * @var Contaienr
	 */
	protected $app;

	/**
	 * The language in which Babel runs
	 *
	 * @var string
	 */
	protected $language;

	/**
	 * Build a new Babel instance
	 */
	public function __construct($language = 'en')
	{
		$me             = $this;
		$this->language = $language;
		$this->app      = new Container;

		$this->app->bind('babel', function() use($me) {
			return $me;
		});

		// Accorders
		$this->app->bind('accord.number', function($app) {
			return new Accorder\Number($app);
		});
	}

	/**
	 * Create a new Babel Sentence
	 *
	 * @return Babel
	 */
	public static function sentence()
	{
		return new Sentence\Sentence;
	}

	/**
	 * Get a class from Babel
	 *
	 * @param  string $key
	 *
	 * @return object
	 */
	public function __get($key)
	{
		$key = String::toSnakeCase($key);
		$key = str_replace('_', '.', $key);

		return $this->app->make($key);
	}

	////////////////////////////////////////////////////////////////////
	/////////////////////////// PUBLIC INTERFACE ///////////////////////
	////////////////////////////////////////////////////////////////////

	/**
	 * Get the repository for a class
	 *
	 * @param  string $class
	 *
	 * @return array
	 */
	public function getRepository($class)
	{
		$class = strtolower(String::baseClass($class));

		$data = include __DIR__.'/../../lang/'.$this->getLanguage().'/'.$class.'.php';

		return new Repository($data);
	}

	/**
	 * Get Babel's current language
	 *
	 * @return string
	 */
	public function getLanguage()
	{
		return $this->language;
	}

}