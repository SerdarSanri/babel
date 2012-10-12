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
   */
  public function __construct($noun = null)
  {
    $this->core = $noun;

    return $this;
  }

  public static function start($noun = null)
  {
    static::$message = new static($noun);

    return static::$message;
  }

  public function __get($key)
  {
    $result = array_get($this->sentence, $key);

    // If no noun has yet been set, fallback to the base concept
    if(!$result and $key == 'noun') $result = $this->core;

    return $result;
  }

  public function __set($key, $value)
  {
    $this->sentence[$key] = $value;
  }

  ////////////////////////////////////////////////////////////////////
  /////////////////////////////// SETTERS ////////////////////////////
  ////////////////////////////////////////////////////////////////////

  /**
   * Add a noun to the sentence
   *
   * @param  string $noun     A noun
   * @param  boolean $article Whether an article should be prepended
   */
  public function noun($noun)
  {
    $this->pattern .= '{noun}';

    // Save noun as core concept if none was defined
    if(!$this->core) $this->core = $noun;

    $this->noun = Babel::noun(Str::singular($noun));

    return $this;
  }

  /**
   * Add a object to the sentence
   *
   * @param  string $object A object
   */
  public function object($object)
  {
    $this->pattern .= '{object}';

    // Try to convert the object to a string
    if(is_object($object)) {
      $object = method_exists($object, '__toString')
        ? $object->__toString()
        : $object->name;
    }

    $this->sentence['object'] = '&laquo; ' .$object. ' &raquo;';

    return $this;
  }

  public function article($article)
  {
    $this->pattern .= '{article}';

    $this->article = Babel::article($article);

    return $this;
  }

  /**
   * Change the state of the sentence, its outcome
   *
   * @param  string $state A state (success/error)
   */
  public function state($state)
  {
    $this->pattern .= '{state}';

    $this->state = Babel::state($state);

    return $this;
  }

  /**
   * Add a number
   *
   * @param  integer $number The number to add
   */
  public function number($number)
  {
    $this->pattern .= '{number}';

    $this->number = Babel::number($number);

    return $this;
  }

  /**
   * Add a precreated bit of sentence
   *
   * @param  string $bit The bit to display
   */
  public function bit($bit)
  {
    $this->pattern .= '{bit}';

    $this->bit = Babel::bit($bit);

    return $this;
  }

  /**
   * Add an adjective to the sentence
   *
   * @param  string $verb A verb
   */
  public function adjective($adjective)
  {
    $this->pattern .= '{adjective}';

    $adjective = Babel::adjective($adjective);

    // Conjugates if a noun precedes the verb
    if(isset($this->sentence['noun'])) {
      $adjective = Accord::adjective($adjective, $this);
    }

    $this->adjective = $adjective;

    return $this;
  }

  /**
   * Add a verb to the sentence
   *
   * @param  string $verb A verb
   */
  public function verb($verb)
  {
    $this->pattern .= '{verb}';

    $this->verb =  Babel::verb($verb);

    return $this;
  }

  ////////////////////////////////////////////////////////////////////
  /////////////////////////////// RETURN /////////////////////////////
  ////////////////////////////////////////////////////////////////////

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

    // Reorder the sentence to match the pattern
    $message = Sentence::reorder($message);

    // Filter the sentence and implode it as a string
    $sentence = array_filter($message->sentence);
    $sentence = ucfirst(implode(' ', $sentence));
    $sentence = str_replace("' ", "'", $sentence);

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
    return $this->speak();
  }

  ////////////////////////////////////////////////////////////////////
  /////////////////////////////// HELPERS ////////////////////////////
  ////////////////////////////////////////////////////////////////////

  public function isFemale()
  {
    return Word::isFemale($this->core);
  }

  public function isPlural()
  {
    if($this->number) return is_int($this->number) and $this->number > 1;
    elseif(Word::isPlural($this->core)) return true;

    return false;
  }
}