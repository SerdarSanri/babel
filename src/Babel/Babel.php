<?php
/**
 *
 * Babel
 *
 * Transforms actions, objects and results
 * into readable sentences
 */
namespace Babel;

use Lang;

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

  ////////////////////////////////////////////////////////////////////
  //////////////////////// PRECREATED SENTENCES //////////////////////
  ////////////////////////////////////////////////////////////////////

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

    $message = Babel::create()->article('the')->noun($noun);
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
    $message = Babel::create();
    $message->verb('add')->article('a')->noun($noun);

    return $message->speak();
  }

  public static function back()
  {
    $message = Babel::create();
    $message->bit('back');

    return $message->speak();
  }

  /**
   * Creates a typical form heading "Edit project X", "Add a client"
   *
   * @param  string $verb   The verb
   * @param  string $noun   The noun
   * @param  string $object The model's representation (ex. $model->name)
   * @return string         A form heading
   */
  public static function form($verb, $noun, $object = null)
  {
    $article = $object ? 'the' : 'a';
    $noun = \Str::singular($noun);

    $message = Babel::create();
    $message->verb($verb)->article($article)->noun($noun);
    if($object) $message->object($object);

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
    $message = Babel::create();

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
    $message = Babel::create();

    $message->number($number)->noun($noun);
    if($verb) $message->verb($verb);

    return $message->speak();
  }

  public static function contains($number, $noun, $container)
  {
    $message = Babel::create();

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

      return Babel::translate($method.'s.'.$word, $word);
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

  public static function getTranslations($file, $key)
  {
    $file = include __DIR__. '/../../lang/fr/'.$file.'.php';

    return \Arrays::get($file, $key);
  }

  /**
   * Translates a string
   *
   * @param string $translation
   * @param string $fallback
   *
   * @return string
   */
  public static function translate($translation, $fallback = null)
  {
    $key = substr($translation, strpos($translation, '.'));
    $key = trim($key, '.');

    $file = str_replace('.'.$key, null, $translation);
    $file = trim($file, '.');
    $file = include __DIR__.'/../../lang/'.Lang::getLocale().'/' .$file. '.php';

    return \Arrays::get($file, $key);
  }
}
