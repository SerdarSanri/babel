<?php
namespace Babel\Sentence;

use Underscore\Methods\StringMethods;

class Sentence
{

	/**
	 * An array of words
	 *
	 * @var array
	 */
	protected $sentence = array();

	/**
	 * Add a word to the Sentence
	 *
	 * @param  string $method
	 * @param  array  $arguments
	 */
	public function __call($method, $arguments)
	{
		$class = 'Babel\Sentence\\'.ucfirst($method);
		if (class_exists($class)) {
			$this->sentence[] = new $class($arguments[0]);
		} else {
			$this->sentence[] = new Word($arguments[0]);
		}

		return $this;
	}

	/**
	 * Get the blueprint of a sentence
	 *
	 * @return string
	 */
	public function getBlueprint()
	{
		foreach ($this->sentence as &$word) {
			$blueprint[] = StringMethods::baseClass(get_class($word));
		}

		return json_encode($blueprint);
	}

	/**
	 * Speak the sentence
	 *
	 * @return string
	 */
	public function speak()
	{
		return implode(' ', $this->sentence);
	}

}