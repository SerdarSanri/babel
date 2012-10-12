<?php
use Babel\Message;

class FrenchMessageTest extends FrenchTests
{
  public function testSentence()
  {
    $message = Message::start()->article('a')->noun('category')->verb('create');

    $this->assertEquals('Une catégorie a bien été créée', $message->speak());
  }
}