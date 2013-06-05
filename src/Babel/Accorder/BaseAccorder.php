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

}