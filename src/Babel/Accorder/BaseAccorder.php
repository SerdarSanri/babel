<?php
namespace Babel\Accorder;

use Illuminate\Container\Container;

abstract class BaseAccorder
{

	/**
	 * A repository holding the Accorder's rules
	 *
	 * @var Repository
	 */
	protected $repository;

	/**
	 * An instance of the Container
	 *
	 * @var Container
	 */
	protected $app;

	/**
	 * Build a new instance of the accorder
	 */
	public function __construct(Container $app)
	{
		$this->app        = $app;
		$this->repository = $app['babel']->getRepository(get_called_class());
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
		// Go through the different patterns
		foreach ($this->repository['patterns'] as $from => $to) {
			if (preg_match($from, $word)) {
				return preg_replace($from, $to, $word);
			}
		}

		return $word;
	}

	/**
	 * Accord a word
	 *
	 * @param  string $word
	 *
	 * @return string
	 */
	abstract function accord($word);

}