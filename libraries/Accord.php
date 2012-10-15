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
   * Accord the different parts of a message between them
   *
   * @param  Message $message The message to accord
   * @return Message          Accorded message
   */
  public static function accord(Message $message)
  {
    // Look for common sentences patterns
    $pattern = $message->pattern;

    if (Sentence::contains('number noun')) {
      $message->number  = Accord::number($message->number);
      $message->noun    = Accord::noun($message->noun);
    } elseif (Sentence::contains('article noun')) {
      $message->article = Accord::article($message->article);
      $message->noun    = Accord::noun($message->noun);
    }

    if (Sentence::contains('noun verb')) {
      $message->pattern = str_replace('verb', 'state verb', $message->pattern);
      $message->sentence['state'] = 'normal';
      if($message->number) $message = Verb::present($message);
      else $message = Verb::past($message);
    } elseif (Sentence::contains('noun( object)? state verb')) {
      $message = Verb::past($message);
    }

    // Conjugate remaining state
    if($message->state == 'normal') {
      $message->state = Babel::state('past.normal');
    }

    return $message;
  }

  ////////////////////////////////////////////////////////////////////
  //////////////////////////////// ACCORDERS /////////////////////////
  ////////////////////////////////////////////////////////////////////

  /**
   * Accord an article
   *
   * @param  string $article An article
   * @return string          An accorded article
   */
  public static function article($article)
  {
    $message = Message::current();

    // Set article to plural if necessary
    if($message->isPlural()) $article = Babel::plural($article);

    switch (Babel::lang()) {
      case 'fr':
        if($message->isFemale()) $article = Accord\Gender::female($article);
        if (starts_with($article, 'l')) {
          if(Word::startsWithVowel($message->noun)) $article = substr($article, 0, -1)."'";
        }
        break;
      case 'en':
        if ($article == 'a') {
          if(Word::startsWithVowel($message->noun)) $article .= 'n';
        }
        break;
    }

    return $article;
  }

  /**
   * Accord a verb
   *
   * @param  string $verb A verb
   * @return string       An accorded verb
   */
  public static function verb($verb)
  {
    $message = Message::current();

    switch (Babel::lang()) {
      case 'fr':
        if($message->isFemale()) $verb .= 'e';
        if($message->isPlural()) $verb .= 's';
        break;
    }

    return $verb;
  }

  /**
   * Accord a noun
   *
   * @param  string $noun A noun
   * @return string       An accorded noun
   */
  public static function noun($noun)
  {
    $message = Message::current();

    switch (Babel::lang()) {
      case 'fr':
      case 'en':
        if($message->isPlural()) $noun = Str::plural($noun);
        break;
    }

    return $noun;
  }

  /**
   * Accord a number
   *
   * @param  string $number A number
   * @return string         An accorded number
   */
  public static function number($number)
  {
    $message = Message::current();

    if(is_int($number)) return $number;

    switch (Babel::lang()) {
      case 'fr':
        if($message->isFemale()) $number .= 'e';
        break;
    }

    return $number;
  }

  /**
   * Accord an adjective
   *
   * @param  string $adjective An adjective
   * @return string            An accorded adjective
   */
  public static function adjective($adjective)
  {
    $message = Message::current();

    switch (Babel::lang()) {
      case 'fr':
        if($message->isFemale()) $adjective .= 'e';
        if(Word::isPlural($message->noun) or $message->number > 1) $adjective .= 's';
    }

    return $adjective;
  }
}
