<?php
/**
 *
 * Verb
 *
 * Helper for verbs
 */
namespace Babel;

class Verb
{
  /**
   * Set a verb to past tense
   *
   * @param  string $verb The verb to modify
   * @return string       Past verb
   */
  public static function past($verb)
  {
    switch(Babel::lang()) {
      case 'fr':
        $verb = substr($verb, 0, -2).'é';
        $verb = Accord::verb($verb);
        break;
      case 'en':
        if(!Word::endsWithVowel($verb)) $verb .= 'e';
        $verb .= 'd';
        break;
    }

    return $verb;
  }
}