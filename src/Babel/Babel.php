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
	 * Build a new Babel instance
	 */
	public function __construct()
	{
		$this->app = new Container;

		// Accorders
		$this->app->bind('accord.number', 'Babel\Accorder\Number');
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

}