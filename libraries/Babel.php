<?php
/**
 *
 * Babel
 *
 * Transforms actions, objects and results
 * into readable sentences
 */
namespace Babel;

use \Str;

class Babel
{
  /**
   * The current message in instance
   * @var Babel
   */
  private static $message;

  /**
   * The different parts of the sentence being created
   * @var array
   */
  private $sentence = array();

  /**
   * The untranslated noun for helpers
   * @var string
   */
  private $noun = null;

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

    static::$message = new static();
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
    static::$message = new static();
    static::$message->verb('add')->noun($noun, 'a');

    return static::$message->__toString();
  }

  public static function nothing($noun)
  {
    static::$message = new static();
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

  ////////////////////////////////////////////////////////////////////
  ///////////////////////////////// RULES ////////////////////////////
  ////////////////////////////////////////////////////////////////////



  /**
   * Conjugate a verb according to a noun
   *
   * @param  string $noun The noun
   * @param  string $verb The verb
   * @return string       The conjugated verb
   */
  public static function conjugate($noun, $verb)
  {
    switch(static::lang()) {
      case 'fr':
        $verb = substr($verb, 0, -2).'é';
        $verb = Accord::verbToNoun($noun, $verb);
        break;
      case 'en':
        if(!Word::endsWithVowel($verb)) $verb .= 'e';
        $verb .= 'd';
        break;
    }

    return $verb;
  }

  ////////////////////////////////////////////////////////////////////
  ////////////////////////////// CORE METHODS ////////////////////////
  ////////////////////////////////////////////////////////////////////

  /**
   * Add a noun to the sentence
   *
   * @param  string $noun     A noun
   * @param  boolean $article Whether an article should be prepended
   */
  public function noun($noun, $article = null)
  {
    // Get noun
    $this->noun = $noun;
    $noun = __('babel::nouns.'.Str::singular($noun));

    if($article) {

      // Get the right article
      $sex = Word::isFemale($this->noun) ? 'female' : 'male';
      $article = __('babel::articles.'.$article.'.'.$sex);
      $article = Accord::articleToNoun($this->noun, $article);

      // Add space if necessary
      if(substr($article, -1) != "'") $article .= ' ';
    }

    $this->sentence['noun'] = $article.$noun;

    return $this;
  }

  /**
   * Add a subject to the sentence
   *
   * @param  string $subject A subject
   */
  public function subject($subject)
  {
    $this->sentence['subject'] = '&laquo; ' .$subject. ' &raquo;';

    return $this;
  }

  /**
   * Change the state of the sentence, its outcome
   *
   * @param  string $state A state (success/error)
   */
  public function state($state)
  {
    $this->sentence['state'] = __('babel::states.'.$state);

    return $this;
  }

  /**
   * Add a number
   *
   * @param  integer $number The number to add
   */
  public function number($number)
  {
    $number = __('babel::numbers.'.$number);
    $this->sentence['number'] = Accord::numberToNoun($this->noun, $number);

    return $this;
  }

  /**
   * Add a bit of sentence
   *
   * @param  string $bit The bit to display
   */
  public function bit($bit)
  {
    $this->sentence[] = __('babel::bits.'.$bit);

    return $this;
  }

  /**
   * Add a verb to the sentence
   *
   * @param  string $verb A verb
   */
  public function verb($verb)
  {
    $verb = __('babel::verbs.'.$verb);

    // Conjugates if a noun precedes the verb
    if($this->noun) {
      $verb = static::conjugate($this->noun, $verb);
    }

    $this->sentence['verb'] = $verb;

    return $this;
  }

  /**
   * Renders the complete sentence
   *
   * @return string A sentence
   */
  public function __toString()
  {
    return ucfirst(implode(' ', $this->sentence));
  }
}