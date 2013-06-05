<?php
/**
 *
 * Word
 *
 * Various helpers to determinate the state
 * of a word
 */
namespace Babel;

use \Lang;
use \Str;

class Word
{
  /**
   * Vowels
   * @var array
   */
  private static $vowels = array(
    'a', 'e', 'i', 'o', 'u',
  );

  /**
   * Checks if a noun is male or female
   *
   * @param  string  $noun A noun
   * @return boolean
   */
  public static function isFemale($noun)
  {
    $noun = Str::singular($noun);
    $female = Babel::getTranslations('accord/genders', 'female');

    return in_array($noun, $female);
  }

  /**
   * Checks if a noun is plural or singular
   *
   * @param  string  $noun A noun
   * @return boolean
   */
  public static function isPlural($noun)
  {
    return Str::plural($noun) == $noun;
  }

  /**
   * Check if a word starts with a vowel
   *
   * @param  string  $word A word
   * @return boolean
   */
  public static function startsWithVowel($word)
  {
    $letter = substr($word, 0, 1);

    return in_array($letter, static::$vowels);
  }

  /**
   * Check if a word ends with a vowel
   *
   * @param  string  $word A word
   * @return boolean
   */
  public static function endsWithVowel($word)
  {
    $letter = substr($word, -1);

    return in_array($letter, static::$vowels);
  }

  /**
   * Mark a word as being female
   *
   * @param string $word A word
   */
  public static function setWordAsFemale($word)
  {
    static::$female[] = $word;
  }
}
