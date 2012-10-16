<?php
use Babel\Accord;
use Babel\Babel;

class SpanishAccordTests extends SpanishTests
{
  public function testAccordArticleNormal()
  {
    $message = Babel::create('pear');
    $babel = Accord::article('la', $message);

    $this->assertEquals("la", $babel);
  }

  public function testAccordWoman()
  {
    $babel = Babel::create()->article('a')->noun('category');

    $this->assertEquals("Una categoría", $babel->speak());
  }
}