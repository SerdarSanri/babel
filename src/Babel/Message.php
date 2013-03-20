<?php
/**
 *
 * Message
 *
 * A message being spoken by Babel
 */
namespace Babel;

use \Str;

class Message
{
  /**
   * The current message in instance
   * @var Message
   */
  private static $message;

  /**
   * The different parts of the sentence being created
   * @var array
   */
  public $sentence = array();

  /**
   * The order of the words
   * @var string
   */
  public $pattern = null;

  /**
   * The untranslated noun for helpers
   * @var string
   */
  public $core = null;

  /**
   * Whether the main noun is female or male
   * @var boolean
   */
  public $female = false;

  /**
   * Whether there are several of the main noun
   * @var boolean
   */
  public $plural = false;

  /**
   * Creates the object and set the core noun
   *
   * @param string $noun A noun
   * @param string $verb A verb
   */
  public function __construct($noun = null, $verb = null)
  {
    $this->core = $noun;

    if($noun) $this->noun($noun);
    if($verb) $this->verb($verb);

    return $this;
  }

  /**
   * Get a value either from the Message or its sentence
   *
   * @param  string $key The key to get
   * @return string      Its value
   */
  public function __get($key)
  {
    $plural = Str::plural($key);

    if($key == $plural) return array_get($this->sentence, $plural, array());

    $result = array_get($this->sentence, $plural.'.'.$plural.'0');

    // If no noun has yet been set, fallback to the base concept
    if(!$result and $key == 'noun') $result = $this->core;

    return $result;
  }

  /**
   * Set a piece of the sentence dynamically
   *
   * @param string $key   The key
   * @param string $value The content
   */
  public function __set($key, $value)
  {
    $key     = Str::plural($key);
    $pattern = $key.'0';

    $this->sentence[$key][$pattern] = $value;
  }

  ////////////////////////////////////////////////////////////////////
  ///////////////////////////// SETTERS //////////////////////////////
  ////////////////////////////////////////////////////////////////////

  /**
   * Add a noun to the sentence
   *
   * @param  string $noun     A noun
   * @param  boolean $article Whether an article should be prepended
   */
  public function noun($noun)
  {
    // Remove end if we passed a controller
    if(str_contains($noun, 'Controller')) {
      $noun = str_replace('_Controller', null, $noun);
      $noun = Str::singular(Str::lower($noun));
    }

    // Save noun as core concept if none was defined
    if(!$this->core) $this->core = $noun;

    $noun = Babel::noun(Str::singular($noun));
    $this->addWord('noun', $noun);

    return $this;
  }

  /**
   * Add a object to the sentence
   *
   * @param  string $object A object
   */
  public function object($object)
  {
    // Try to convert the object to a string
    if (is_object($object)) {
      $object = method_exists($object, '__toString')
        ? $object->__toString()
        : $object->name;
    }

    $object = '&laquo; ' .$object. ' &raquo;';
    $this->addWord('object', $object);

    return $this;
  }

  public function article($article)
  {
    $this->addWord('article', Babel::article($article));

    return $this;
  }

  /**
   * Change the state of the sentence, its outcome
   *
   * @param  string $state A state (success/error)
   */
  public function state($state)
  {
    $this->addWord('state', Babel::state($state));

    return $this;
  }

  /**
   * Add a number
   *
   * @param  integer $number The number to add
   */
  public function number($number)
  {
    $this->addWord('number', Babel::number($number));

    return $this;
  }

  /**
   * Add a precreated bit of sentence
   *
   * @param  string $bit The bit to display
   */
  public function bit($bit)
  {
    $this->addWord('bit', Babel::bit($bit));

    return $this;
  }

  /**
   * Add an adjective to the sentence
   *
   * @param  string $verb A verb
   */
  public function adjective($adjective)
  {
    $adjective = Babel::adjective($adjective);

    // Conjugates if a noun precedes the verb
    if (isset($this->noun)) {
      $adjective = Accord::adjective($adjective, $this);
    }

    $this->addWord('adjective', $adjective);

    return $this;
  }

  /**
   * Add a verb to the sentence
   *
   * @param  string $verb A verb
   */
  public function verb($verb)
  {
    // If we passed a controller's action
    if(str_contains($verb, '_')) {
      $verb = array_get(explode('_', $verb), 1);
    }

    $verb = Babel::verb($verb);
    $this->addWord('verb', $verb);

    return $this;
  }

  ////////////////////////////////////////////////////////////////////
  /////////////////////////////// RETURN /////////////////////////////
  ////////////////////////////////////////////////////////////////////

  /**
   * Set the current message being creater
   *
   * @param  Message $message
   */
  public static function message(Message $message)
  {
    static::$message = $message;
  }

  /**
   * Fetch the current message being created
   * @return Message
   */
  public static function current()
  {
    return static::$message;
  }

  /**
   * Renders the complete sentence
   *
   * @return string A sentence
   */
  public function speak()
  {
    // Apply all rules to found words
    $message = Accord::accord($this);

    // Replace patterns with their value
    $sentence = Sentence::createFrom($message->pattern, $message->sentence);

    // Destroy message instance
    static::$message = null;

    return $sentence;
  }

  /**
   * Renders the complete sentence
   *
   * @return string A sentence
   */
  public function __toString()
  {
    try {
      $this->speak();
    }
    catch (\Exception $e) {
      var_dump($e->getMessage());
    }
    return $this->speak();
  }

  ////////////////////////////////////////////////////////////////////
  /////////////////////////////// HELPERS ////////////////////////////
  ////////////////////////////////////////////////////////////////////

  /**
   * Add something to the current pattern
   *
   * @param string $pattern The part to add
   */
  public function addWord($type, $value)
  {
    $type = Str::plural($type);

    // Get count
    $count = array_get($this->sentence, $type, array());
    $count = sizeof($count);

    // Save word
    $this->sentence[$type][$type.$count] = $value;

    // Add pattern
    if(!empty($this->pattern)) $this->pattern .= ' ';
    $this->pattern .= $type.$count;

    return $type;
  }

  /**
   * Set a part of a sentence
   *
   * @param string $key   The word pattern
   * @param string $value Its value
   */
  public function setWord($key, $value)
  {
    $this->sentence[substr($key, 0, -1)][$key] = $value;
  }

  public function isFemale()
  {
    return Word::isFemale($this->core);
  }

  public function isPlural($noun = null)
  {
    if(!$noun) $noun = $this->core;

    if($this->number) return is_int($this->number) and $this->number > 1;
    elseif(Word::isPlural($noun)) return true;
    return false;
  }
}
