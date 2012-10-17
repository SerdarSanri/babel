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
   * A list of extended Babel sentences
   * @var array
   */
  private static $extend = array();

  /**
   * Creates a new instance of the Message class
   *
   * @param  string $noun A noun
   * @param  string $verb A verb
   */
  public static function create($noun = null, $verb = null)
  {
    Message::message(new Message($noun, $verb));

    return Message::current();
  }

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

    $message = Babel::create($noun)->article('the')->noun($noun);
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
    $message = Babel::create($noun);
    $message->verb('add')->article('a')->noun($noun);

    return $message->speak();
  }

  /**
   * Creates a "No X Yed" message
   *
   * @param  string $noun The noun to use
   * @return string
   */
  public static function no($noun, $verb = null)
  {
    $message = Babel::create($noun);

    $message->number(0)->noun($noun);
    if($verb == 'display') $message->bit('to');
    if($verb) $message->verb($verb);

    return $message->speak();
  }

  /**
   * Creates a "X Y were Zed" message
   *
   * @param  integer $number The number of the noun
   * @param  string  $noun   The noun to use
   * @param  string  $verb   The verb to use
   * @return string
   */
  public static function many($number, $noun, $verb = null)
  {
    $message = Babel::create($noun);

    $message->number($number)->noun($noun);
    if($verb) $message->verb($verb);

    return $message->speak();
  }

  public static function contains($number, $noun, $container)
  {
    $message = Babel::create($noun);

    $message->number($number)->noun($noun)->bit('in')->article('this')->noun($container);

    return $message->speak();
  }

  /**
   * Extends Babels precreated sentences
   *
   * @param  string  $name    The name of the new sentence
   * @param  Closure $closure Closure with arguments
   * @return mixed            A message object or a string
   */
  public static function extend($name, \Closure $closure)
  {
    static::$extend[$name] = $closure;
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
   * Automatic transation and verb setting
   *
   * @param  string $method     The kind of word to translate
   * @param  string $parameters The key to get
   * @return string             Translated word
   */
  public static function __callStatic($method, $parameters)
  {
    // Check for an extended sentence
    if(isset(static::$extend[$method])) {
      return call_user_func_array(static::$extend[$method], $parameters);
    }

    // Get a custom translation
    if (in_array($method, array('adjective', 'article', 'bit', 'noun', 'number', 'plural', 'state', 'verb'))) {
      $word = array_get($parameters, 0);
      if(is_null($word)) return false;

      return __('babel::'.$method.'s.'.$word)->get(null, $word);
    }

    // Verb setting
    $parameters[] = rtrim($method, 'd');
    return call_user_func_array('static::many', $parameters);
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
