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

    if (list($number, $noun, $verb) = Sentence::contains('numbers nouns (verbs)?')) {
      $message->setWord($number, Accord::number($message->numbers[$number]));
      $message->setWord($noun, Accord::noun($message->nouns[$noun]));
    }

    if (list($article, $noun) = Sentence::contains('articles nouns')) {
      $message->article = Accord::article($message->article);
      $message->setWord($noun, Accord::noun($message->nouns[$noun]));
    }

    if (Sentence::contains('nouns verbs')) {
      $message->pattern = str_replace('verbs0', 'states0 verbs0', $message->pattern);
      $message->state = 'normal';
      $tense = $message->number ? 'present' : 'past';
      $message = Verb::$tense($message);
    } elseif (Sentence::contains('nouns( objects)? states verbs')) {
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
    if($message->isPlural()) $article = Accord\Number::plural($article);
    if($message->isFemale()) $article = Accord\Gender::female($article);

    switch (Babel::lang()) {
      case 'fr':
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
    if(Babel::lang() == 'en') return $verb;

    if(Babel::lang() == 'sp') var_dump($verb);
    if($message->isPlural()) $verb = Accord\Number::plural($verb);
    if(Babel::lang() == 'sp') var_dump($verb);
    if($message->isFemale()) $verb = Accord\Gender::female($verb);
    if(Babel::lang() == 'sp') var_dump($verb);

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
    if($message->isPlural()) $noun = Accord\Number::plural($noun);

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
