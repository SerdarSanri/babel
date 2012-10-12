<?php
/**
 *
 * Genderize
 *
 * Handles the transition from female to male and vice versa
 */
namespace Babel\Accord;

use \Babel\Word;
use \Babel\Babel;

class Genderize
{
  /**
   * Transform any word to its female version
   *
   * @param  string $word A word
   * @return string       A feminized word
   */
  public static function female($word)
  {
    // If the world is invariable, don't touch it
    if(static::invariable($word)) return $word;

    // If it's irregular, return the feminized form
    if(static::irregular($word)) return static::irregular($word);

    // Else look for patterns ans replace
    foreach(__('babel::genders.feminize')->get() as $pattern => $replace) {
      if(preg_match($pattern, $word)) {
        return preg_replace($pattern, $replace, $word);
      }
    }

    return $word;
  }

  /**
   * Checks if a word's gender is invariable
   *
   * @param  string  $word A word
   * @return boolean       Invariable or not
   */
  public static function invariable($word)
  {
    return in_array($word, __('babel::genders.invariable')->get());
  }

  /**
   * Checks if a word's gender is irregular, if so return it
   *
   * @param  string $word A word
   * @return string       Irregular form or original word
   */
  public static function irregular($word)
  {
    $irregular = __('babel::genders.irregular')->get();

    if(isset($irregular[$word])) return $irregular[$word];
    else return false;
  }
}