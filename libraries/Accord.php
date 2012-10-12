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

  public static function accord($message)
  {
    // Look for common sentences patterns
    $pattern = $message->pattern;

    if(Sentence::contains('{number}{noun}')) {
      $message->number  = Accord::number($message->number);
      $message->noun    = Accord::noun($message->noun);
    } elseif(Sentence::contains('{article}{noun}')) {
      $message->article = Accord::article($message->article);
      $message->noun    = Accord::noun($message->noun);
    }

    if(Sentence::contains('{noun}{verb}')) {
      $message->pattern = str_replace('{verb}', '{state}{verb}', $message->pattern);
      $message->sentence['state'] = Babel::state('success');
      $message->verb = Verb::past($message->verb);
    } elseif(Sentence::contains('{noun}({object})?{state}{verb}')) {
      $message->verb = Verb::past($message->verb);
    }

    return $message;
  }

  /**
   * Accord an article to its noun
   *
   * @param  string $noun    A noun
   * @param  string $article An article
   * @return string          An accorded article
   */
  public static function article($article)
  {
    $message = Message::current();

    if($message->isPlural()) $article = Babel::plural($article);

    switch(Babel::lang()) {
      case 'fr':
        if($message->isFemale()) $article = Accord\Genderize::female($article);
        if(starts_with($article, 'l')) {
          if(Word::startsWithVowel($message->noun)) $article = substr($article, 0, -1)."'";
        }
        break;
      case 'en':
        if($article == 'a') {
          if(Word::startsWithVowel($message->noun)) $article .= 'n';
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
  public static function verb($verb)
  {
    $message = Message::current();

    switch(Babel::lang()) {
      case 'fr':
        if($message->isFemale()) $verb .= 'e';
        break;
    }

    return $verb;
  }

  public static function noun($noun)
  {
    $message = Message::current();

    switch(Babel::lang()) {
      case 'fr':
      case 'en':
        if($message->isPlural()) $noun = Str::plural($noun);
        break;
    }

    return $noun;
  }

  public static function number($number)
  {
    $message = Message::current();

    if(is_int($number)) return $number;

    switch(Babel::lang()) {
      case 'fr':
        if($message->isFemale()) $number .= 'e';
        break;
    }

    return $number;
  }

  public static function adjective($adjective)
  {
    $message = Message::current();

    switch(Babel::lang()) {
      case 'fr':
        if($message->isFemale()) $adjective .= 'e';
        if(Word::isPlural($message->noun) or $message->number > 1) $adjective .= 's';
    }

    return $adjective;
  }
}