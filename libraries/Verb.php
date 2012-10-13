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
  public static function conjugate(Message $message)
  {
    $verb = $message->verb;

    switch (Babel::lang()) {
      case 'fr':
        $verb = substr($verb, 0, -2).'é';
        $verb = Accord::verb($verb);
        break;
      case 'en':
        if(!Word::endsWithVowel($verb)) $verb .= 'e';
        $verb .= 'd';
        break;
    }

    $message->verb = $verb;

    return $message;
  }

  public static function present(Message $message)
  {
    $state = Babel::state('present.'.$message->state);

    $message->state = $state;

    return static::conjugate($message);
  }

  public static function past(Message $message)
  {
    $state = Babel::state('past.'.$message->state);

    switch (Babel::lang()) {
      case 'fr':
        if($message->isPlural()) $state = str_replace('a été', 'ont été', $state);
        break;
      case 'en':
        if($message->isPlural()) $state = str_replace('was', 'were', $state);
        break;
    }

    $message->state = $state;

    return static::conjugate($message);
  }
}
