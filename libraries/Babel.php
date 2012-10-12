<?php
/**
 *
 * Babel
 *
 * Transforms actions, objects and results
 * into readable sentences
 */
namespace Babel;

class Babel
{
  /**
   * The current message in instance
   * @var Message
   */
  private static $message;

  /**
   * Builds a restful message
   *
   * @param  string  $subject The current subject
   * @param  string  $object  The object's name
   * @param  string  $verb    The CRUD verb
   * @param  boolean $string  The state of the action (failed or succeeded)
   * @return string           A text message
   */
  public static function restful($subject, $object, $verb, $state = true)
  {
    $bool  = $state ? 'success' : 'error';

    $message = new Message();
    $message->noun($subject, 'the');
    if($object) $message->subject($object);
    $message->state($bool)->verb($verb);

    return \Alert::$bool($message, false);
  }

  /**
   * Creates an "Add a [something]" message
   *
   * @param string $noun The base noun
   */
  public static function add($noun)
  {
    $message = new Message();
    $message->verb('add')->noun($noun, 'a');

    return $message->speak();
  }

  public static function nothing($noun)
  {
    $message = new Message();
    $message->noun = $noun;

    $message->number(0)->noun($noun)->bit('to_display');

    return $message->speak();
  }

  /**
   * Fetch and display a message from session
   *
   * @return string A message in an alert
   */
  public static function displayMessage()
  {
    if(\Session::has('message')) {
      return \Session::get('message');
    }
  }

  ////////////////////////////////////////////////////////////////////
  ////////////////////////////// TRANSLATE ///////////////////////////
  ////////////////////////////////////////////////////////////////////

  /**
   * Get a verb
   *
   * @param  string $verb The verb to get
   * @return string       Translated verb
   */
  public static function verb($verb)
  {
    return __('babel::verbs.'.$verb);
  }

  ////////////////////////////////////////////////////////////////////
  ////////////////////////////// HELPERS /////////////////////////////
  ////////////////////////////////////////////////////////////////////

  /**
   * Get the current language
   *
   * @return string The language in use
   */
  public static function lang()
  {
    return \Config::get('application.language');
  }
}