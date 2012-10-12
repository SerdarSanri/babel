<?php
/**
 *
 * Sentence
 *
 * Analyzes a sentence's pattern and modify it
 */
namespace Babel;

class Sentence
{
  /**
   * Check if a message's sentence matches a pattern
   *
   * @param  string  $regex   The pattern
   * @param  Message $message
   * @return boolean          Matches or not
   */
  public static function contains($regex)
  {
    return preg_match('/'.$regex.'/', Message::current()->pattern);
  }

  /**
   * Get the current Message's sentence as a pattern
   *
   * @param Message $message The message to get the sentence
   * @return string
   */
  public static function asPattern(Message $message)
  {
    return '{'.implode('}{', array_keys($message->sentence)).'}';
  }

  /**
   * Reorder the order of the Message's sentence if it
   * doesn't match its pattern
   *
   * @param Message $message The message to reorder
   */
  public static function reorder(Message $message)
  {
    if($message->pattern == Sentence::asPattern($message)) return $message;

    // Transform the pattern into an array and reorder according to it
    preg_match_all('/{([a-z]+)}/', $message->pattern, $pattern);
    foreach($pattern[1] as $p) {
      $_sentence[$p] = $message->$p;
    }

    // Update the message's pattern
    $message->sentence = $_sentence;

    return $message;
  }

}