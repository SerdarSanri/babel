<?php
namespace Babel\Sentence;

class Word
{

	/**
	 * The word
	 *
	 * @var string
	 */
	protected $word;

	/**
	 * Build a new Word
	 *
	 * @param string $word
	 */
	public function __construct($word)
	{
		$this->word = $word;
	}

	/**
	 * Prints out the word
	 *
	 * @return string
	 */
	public function __toString()
	{
		return (string) $this->word;
	}

}