<?php
use Babel\Accord;
use Babel\Message;

class FrenchAccordTests extends FrenchTests
{
  public function testAccordArticleNormal()
  {
    $message = Message::start('poire');
    $babel = Accord::article('la', $message);

    $this->assertEquals("la", $babel);
  }

  public function testAccordArticle()
  {
    $message = Message::start('arbre');
    $babel = Accord::article('le', $message);

    $this->assertEquals("l'", $babel);
  }

  public function testAccordWoman()
  {
    $message = Message::start('category');
    $babel = Accord::article('un', $message);

    $this->assertEquals("une", $babel);
  }
}