<?php
namespace Babel;

class Repository
{

	/**
	 * The core data in the Repository
	 *
	 * @var array
	 */
	protected $repository;

	/**
	 * Build a new Repository
	 *
	 * @param array $repository
	 */
	public function __construct(array $repository)
	{
		$this->repository = $repository;
	}

	/**
	 * Get the rule for a word
	 *
	 * @param  string $word
	 *
	 * @return string
	 */
	public function inflect($word)
	{
		foreach ($this->repository['patterns'] as $from => $to) {
			if (preg_match($from, $word)) {
				$word = preg_replace($from, $to, $word);
			}
		}

		return $word;
	}

}