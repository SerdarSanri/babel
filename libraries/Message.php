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
   * The different parts of the sentence being created
   * @var array
   */
  private $sentence = array();

  /**
   * The untranslated noun for helpers
   * @var string
   */
  private $core = null;

  /**
   * Add a noun to the sentence
   *
   * @param  string $noun     A noun
   * @param  boolean $article Whether an article should be prepended
   */
  public function noun($noun, $article = null)
  {
    // Get noun
    $this->core = $noun;
    $noun = __('babel::nouns.'.Str::singular($noun));

    if($article) {

      // Get the right article
      $sex = Word::isFemale($this->core) ? 'female' : 'male';
      $article = __('babel::articles.'.$article.'.'.$sex);
      $article = Accord::articleToNoun($this->core, $article);

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
    $this->sentence['number'] = Accord::numberToNoun($this->core, $number);

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
    if($this->core) {
      $verb = Verb::conjugate($this->core, $verb);
    }

    $this->sentence['verb'] = $verb;

    return $this;
  }

  ////////////////////////////////////////////////////////////////////
  /////////////////////////////// RETURN /////////////////////////////
  ////////////////////////////////////////////////////////////////////

  /**
   * Renders the complete sentence
   *
   * @return string A sentence
   */
  public function speak()
  {
    return ucfirst(implode(' ', $this->sentence));
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
}