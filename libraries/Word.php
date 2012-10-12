<?php
/**
 *
 * Word
 *
 * Various helpers to determinate the state
 * of a word
 */
namespace Babel;

use \Str;

class Word
{
  /**
   * An array of female nouns
   * @var array
   */
  private static $female = array(
    'category',
  );

  /**
   * Vowels
   * @var array
   */
  private static $vowels = array(
    'a', 'e', 'i', 'o', 'u', 'y',
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

    return in_array($noun, static::$female);
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
}