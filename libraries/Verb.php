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
   * Conjugate a verb according to a noun
   *
   * @param  string $noun The noun
   * @param  string $verb The verb
   * @return string       The conjugated verb
   */
  public static function conjugate($noun, $verb)
  {
    switch(Babel::lang()) {
      case 'fr':
        $verb = substr($verb, 0, -2).'é';
        $verb = Accord::verbToNoun($noun, $verb);
        break;
      case 'en':
        if(!Word::endsWithVowel($verb)) $verb .= 'e';
        $verb .= 'd';
        break;
    }

    return $verb;
  }
}