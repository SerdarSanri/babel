<?php
/**
 *
 * Tense
 *
 * Conjugate verbs
 */
namespace Babel\Accord;

class Tense extends \Babel\Accord\Accorder
{
  /**
   * Returns a verb to its Present tense
   *
   * @param  string $verb A verb
   * @return string       Its conjugated form
   */
  public static function present($verb)
  {
    static::$repository = 'verbs.present';

    return static::getWord($verb);
  }

  /**
   * Returns a verb to its Present tense
   *
   * @param  string $verb A verb
   * @return string       Its conjugated form
   */
  public static function past($verb)
  {
    static::$repository = 'verbs.past';

    return static::getWord($verb);
  }
}
