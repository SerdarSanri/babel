<?php
use Babel\Babel;

class EnglishMessageTest extends EnglishTests
{
  public function testSentence()
  {
    $message = Babel::create()->article('the')->noun('user')->verb('create');

    $this->assertEquals('The user was created', $message->speak());
  }

  public function testControllerAsNoun()
  {
    $message = Babel::create()->article('the')->noun('Users_Controller')->verb('create');

    $this->assertEquals('The user was created', $message->speak());
  }

  public function testActionAsVerb()
  {
    $message = Babel::create()->article('the')->noun('Users_Controller')->verb('post_create');

    $this->assertEquals('The user was created', $message->speak());
  }

  public function testNothingRecently()
  {
    $message = Babel::create()->number(0)->noun('document')->verb('create')->bit('recently');

    $this->assertEquals('No document created recently', $message->speak());
  }

  public function testResults()
  {
    $message = Babel::create()->number(4)->noun('result');

    $this->assertEquals('4 results', $message->speak());
  }
}