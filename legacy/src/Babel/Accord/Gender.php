<?php
/**
 *
 * Gender
 *
 * Handles the transition from female to male and vice versa
 */
namespace Babel\Accord;

class Gender extends \Babel\Accord\Accorder
{
  protected static $repository = 'genders';

  /**
   * Transform any word to its female version
   *
   * @param  string $word A word
   * @return string       A feminized word
   */
  public static function female($word)
  {
    return static::getWord($word, 'feminize');
  }
}
