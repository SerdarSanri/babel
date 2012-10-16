<?php
/**
 *
 * Accorder
 *
 * An abstract class for Accorders
 */
namespace Babel\Accord;

use \Lang;

abstract class Accorder
{
  protected static $repository;

  /**
   * Checks if a word's gender is invariable
   *
   * @param  string  $word A word
   * @return boolean       Invariable or not
   */
  protected static function invariable($word)
  {
    return in_array($word, Lang::line('babel::accord/'.static::$repository.'.invariable')->get());
  }

  /**
   * Checks if a word's gender is irregular, if so return it
   *
   * @param  string $word A word
   * @return string       Irregular form or original word
   */
  protected static function irregular($word)
  {
    $irregular = Lang::line('babel::accord/'.static::$repository.'.irregular')->get();

    if(isset($irregular[$word])) return $irregular[$word];
    else return null;
  }

  /**
   * Get the correct form of a word
   *
   * @param  string $word     The word to fetch
   * @param  string $patterns A particular patterns array to fetch from
   * @return string           Correct form of the word
   */
  protected static function getWord($word, $patterns = 'patterns')
  {

    // If the world is invariable, don't touch it
    if(static::invariable($word)) return $word;

    // If it's irregular, return the correct form
    if(!is_null(static::irregular($word))) return static::irregular($word);

    // Else look for patterns ans replace
    foreach (Lang::line('babel::accord/' .static::$repository. '.'.$patterns)->get() as $pattern => $replace) {
      if (preg_match($pattern, $word)) {
        return preg_replace($pattern, $replace, $word);
      }
    }

    // Special case for english language to use Laravel's plural function
    if(\Babel::lang() == 'en' and static::$repository == 'plurals') return \Str::plural($word);

    return $word;
  }
}
