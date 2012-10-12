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
   * @param  string  $page   The current page
   * @param  string  $object The object's name
   * @param  string  $verb   The CRUD verb
   * @param  boolean $string The state of the action (failed or succeeded)
   * @return string          A text message
   */
  public static function restful($page, $object, $verb, $state = true)
  {
    $bool  = $state ? 'success' : 'error';

    static::$message = new Message();
    static::$message->noun($page, 'the');
    if($object) static::$message->subject($object);
    static::$message->state($bool)->verb($verb);

    return \Alert::$bool(static::$message, false);
  }

  /**
   * Creates an "Add a [something]" message
   *
   * @param string $noun The base noun
   */
  public static function add($noun)
  {
    static::$message = new Message();
    static::$message->verb('add')->noun($noun, 'a');

    return static::$message->__toString();
  }

  public static function nothing($noun)
  {
    static::$message = new Message();
    static::$message->noun = $noun;

    static::$message->number(0)->noun($noun)->bit('to_display');

    return static::$message->__toString();
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