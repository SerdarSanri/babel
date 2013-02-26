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
   * Conjugate, accord and store a verb in a Message
   *
   * @param  Message $message The message
   * @return Message          The message with conjugated verb
   */
  private static function conjugate(Message $message)
  {
    // Accord verb
    $verb = Accord\Tense::past($message->verb);
    $verb = Accord::verb($verb);

    // Save it
    $message->verb = $verb;

    return $message;
  }

  /**
   * Accord a verb to its present form
   *
   * @param  Message $message
   * @return Message
   */
  public static function present(Message $message)
  {
    // Get translated form of the state
    $state = Babel::state('present.'.$message->state);

    // Save it
    $message->state = $state;

    return static::conjugate($message);
  }

  /**
   * Accord a verb to its past form
   *
   * @param  Message $message
   * @return Message
   */
  public static function past(Message $message)
  {
    // Get translated form of the state
    $state = Babel::state('past.'.$message->state);

    // Pluralize if necessary
    switch (Babel::lang()) {
      case 'fr':
        if($message->isPlural()) $state = str_replace('a été', 'ont été', $state);
        break;
      case 'en':
        if($message->isPlural()) $state = str_replace('was', 'were', $state);
        break;
    }

    // Save it
    $message->state = $state;

    return static::conjugate($message);
  }
}
