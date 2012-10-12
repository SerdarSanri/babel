<?php
/**
 *
 * Accord
 *
 * Accord words to male, female, plural, singular, etc
 */
namespace Babel;

use \Str;

class Accord
{

  /**
   * Accord an article to its noun
   *
   * @param  string $noun    A noun
   * @param  string $article An article
   * @return string          An accorded article
   */
  public static function articleToNoun($noun, $article)
  {
    switch(Babel::lang()) {
      case 'fr':
        if(starts_with($article, 'l')) {
          if(Word::startsWithVowel($noun)) $article = substr($article, 0, -1)."'";
        }
        break;
      case 'en':
        if($article == 'a') {
          if(Word::startsWithVowel($noun)) $article .= 'n';
        }
        break;
    }

    return $article;
  }

  /**
   * Accord a verb to its noun
   *
   * @param  string $verb A verb
   * @return string       An accorded verb
   */
  public static function verbToNoun($noun, $verb)
  {
    switch(Babel::lang()) {
      case 'fr':
        if(Word::isFemale($noun)) $verb .= 'e';
        break;
    }

    return $verb;
  }

  public static function numberToNoun($noun, $number)
  {
    switch(Babel::lang()) {
      case 'fr':
        if(Word::isFemale($noun)) $number .= 'e';
        break;
    }

    return $number;
  }
}