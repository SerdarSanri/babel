<?php
/**
 *
 * Genderize
 *
 * Handles the transition from female to male and vice versa
 */
namespace Babel\Accord;

use \Babel\Word;

class Genderize
{
  /**
   * Cached list of irregular words
   * @var array
   */
  private static $irregular;

  /**
   * Cached list of feminizing patterns
   * @var array
   */
  private static $feminize;

  /**
   * Cached list of invariable words
   * @var array
   */
  private static $invariable;

  /**
   * Cache all list for future reference
   */
  public function __construct()
  {
    static::$irregular  = __('babel::genders.irregular')->get();
    static::$feminize   = __('babel::genders.feminize')->get();
    static::$invariable = __('babel::genders.invariable')->get();
  }

  /**
   * Transform any word to its female version
   *
   * @param  string $word A word
   * @return string       A feminized word
   */
  public static function female($word)
  {
    // If the world is invariable, don't touch it
    if(in_array($word, static::$invariable)) return $word;

    // If it's irregular, return the feminized form
    if(isset(static::$irregular[$word])) return static::$irregular[$word];

    // Else look for patterns ans replace
    foreach(static::$feminize as $pattern => $replace) {
      if(preg_match($pattern, $word)) {
        return preg_replace($pattern, $replace, $word);
      }
    }
  }
}