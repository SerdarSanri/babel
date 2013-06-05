<?php
use Babel\Babel;

class FrenchMessageTest extends FrenchTests
{
  public function testSentence()
  {
    $message = Babel::create()->article('a')->noun('category')->verb('create');

    $this->assertEquals('Une catégorie a été créée', $message->speak());
  }

  public function testControllerAsNoun()
  {
    $message = Babel::create()->article('the')->noun('Users_Controller')->verb('create');

    $this->assertEquals('L\'utilisateur a été créé', $message->speak());
  }

  public function testActionAsVerb()
  {
    $message = Babel::create()->article('the')->noun('Users_Controller')->verb('post_create');

    $this->assertEquals('L\'utilisateur a été créé', $message->speak());
  }

  public function testNothingRecently()
  {
    $message = Babel::create()->number(0)->noun('document')->verb('create')->bit('recently');

    $this->assertEquals('Aucun document créé récemment', $message->speak());
  }

  public function testResults()
  {
    $message = Babel::create()->number(4)->noun('result');

    $this->assertEquals('4 résultats', $message->speak());
  }
}