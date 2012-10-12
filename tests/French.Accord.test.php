<?php
use Babel\Accord;
use Babel\Babel;

class FrenchAccordTests extends FrenchTests
{
  public function testAccordArticleNormal()
  {
    $message = Babel::create('poire');
    $babel = Accord::article('la', $message);

    $this->assertEquals("la", $babel);
  }

  public function testAccordArticle()
  {
    $message = Babel::create('arbre');
    $babel = Accord::article('le', $message);

    $this->assertEquals("l'", $babel);
  }

  public function testAccordWoman()
  {
    $message = Babel::create('category');
    $babel = Accord::article('un', $message);

    $this->assertEquals("une", $babel);
  }
}