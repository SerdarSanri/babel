<?php
use Babel\Message;

class FrenchMessageTest extends FrenchTests
{
  public function testSentence()
  {
    $message = Message::start()->article('a')->noun('category')->verb('create');

    $this->assertEquals('Une catégorie a été créée', $message->speak());
  }

  public function testControllerAsNoun()
  {
    $message = Message::start()->article('the')->noun('Users_Controller')->verb('create');

    $this->assertEquals('L\'utilisateur a été créé', $message->speak());
  }

  public function testActionAsVerb()
  {
    $message = Message::start()->article('the')->noun('Users_Controller')->verb('post_create');

    $this->assertEquals('L\'utilisateur a été créé', $message->speak());
  }
}