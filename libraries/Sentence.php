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
    $pattern = Message::current()->pattern;
    $regex = preg_replace('/([a-z]+)( )?/', '($1\\\\d?)$2', $regex);
    preg_match_all('/'.$regex.'/', $pattern, $matches);

    if(!empty($matches[0][0])) {
      return explode(' ', $matches[0][0]);
    }

    return !empty($matches[0]);
  }

  /**
   * Get the current Message's sentence as a pattern
   *
   * @param Message $message The message to get the sentence
   * @return string
   */
  public static function asPattern(Message $message)
  {
    return implode(' ', array_keys($message->sentence));
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
    preg_match_all('/([a-z]+[0-9]{0,}) ?/', $message->pattern, $pattern);
    foreach ($pattern[1] as $p) {
      $_sentence[$p] = $message->$p;
    }

    // Update the message's pattern
    $message->sentence = $_sentence;

    return $message;
  }

  public static function createFrom($pattern, $_sentence)
  {
    // Flatten sentence arrayfunction flatten(array $array) {
    foreach($_sentence as $type => $words) {
      foreach($words as $key => $word) {
        $sentence[$key] = $word;
      }
    }

    // Clean sentence
    $sentence = strtr($pattern, $sentence);

    return static::clean($sentence);
  }


  private static function clean($sentence)
  {
    $sentence = str_replace('  ', ' ', $sentence);
    $sentence = ucfirst(trim($sentence));
    $sentence = str_replace("' ", "'", $sentence);

    return $sentence;
  }

}
