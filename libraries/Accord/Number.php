<?php
/**
 *
 * Plurals
 *
 * Handles transition to plural and singular
 */
namespace Babel\Accord;

class Number extends \Babel\Accord\Accorder
{
  protected static $repository = 'plurals';

  /**
   * Transform any word to its plural version
   *
   * @param  string $word A word
   * @return string       A plural word
   */
  public static function plural($word)
  {
    $plural = static::getWord($word);

    return $plural;
  }
}
