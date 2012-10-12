<?php
use Babel\Message;

class EnglishMessageTest extends EnglishTests
{
  public function testSentence()
  {
    $message = Message::start()->article('the')->noun('user')->verb('create');

    $this->assertEquals('The user was created', $message->speak());
  }

  public function testControllerAsNoun()
  {
    $message = Message::start()->article('the')->noun('Users_Controller')->verb('create');

    $this->assertEquals('The user was created', $message->speak());
  }

  public function testActionAsVerb()
  {
    $message = Message::start()->article('the')->noun('Users_Controller')->verb('post_create');

    $this->assertEquals('The user was created', $message->speak());
  }
}