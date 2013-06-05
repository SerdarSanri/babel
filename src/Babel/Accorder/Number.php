<?php
namespace Babel\Accorder;

/**
 * Accords words with their number
 */
class Number extends BaseAccorder
{

	/**
	 * Accord a word with a number
	 *
	 * @param  string  $word
	 * @param  integer $number
	 *
	 * @return string
	 */
	public function accord($word, $number)
	{
		return $number. ' ' .$this->repository->inflect($word);
	}

}