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
   * Builds a restful message
   *
   * @param  string  $noun    The base noun
   * @param  string  $object  The object's name
   * @param  string  $verb    The CRUD verb
   * @param  boolean $string  The state of the action (failed or succeeded)
   * @return string           A text message
   */
  public static function restful($noun, $object, $verb, $state = true)
  {
    $state  = $state ? 'success' : 'error';

    $message = Message::start($noun)->article('the')->noun($noun);
    if($object) $message->object($object);
    $message->state($state)->verb($verb);

    return '<div class="alert alert-'.$state. '">' .$message. '</div>';
  }

  /**
   * Creates an "Add a [something]" message
   *
   * @param  string $noun The base noun
   * @return string
   */
  public static function add($noun)
  {
    $message = Message::start($noun);
    $message->verb('add')->article('a')->noun($noun);

    return $message->speak();
  }

  /**
   * Creates a "No X to display" message
   *
   * @param  string $noun The noun to use
   * @return string
   */
  public static function nothing($noun)
  {
    $message = Message::start($noun);

    $message->number(0)->noun($noun)->bit('to_display');

    return $message->speak();
  }

  public static function many($number, $noun)
  {
    $message = Message::start($noun);

    $message->number($number)->noun($noun)->adjective('display');

    return $message->speak();
  }

  /**
   * Fetch and display a message from session
   *
   * @return string A message in an alert
   */
  public static function displayMessage()
  {
    if (\Session::has('message')) {
      return \Session::get('message');
    }
  }

  ////////////////////////////////////////////////////////////////////
  ////////////////////////////// TRANSLATE ///////////////////////////
  ////////////////////////////////////////////////////////////////////

  /**
   * Automatic transation
   *
   * @param  string $method     The kind of word to translate
   * @param  string $parameters The key to get
   * @return string             Translated word
   */
  public static function __callStatic($method, $parameters)
  {
    if (in_array($method, array('adjective', 'article', 'bit', 'noun', 'number', 'plural', 'state', 'verb'))) {
      $word = array_get($parameters, 0);
      if(is_null($word)) return false;

      return __('babel::'.$method.'s.'.$word)->get(null, $word);
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
