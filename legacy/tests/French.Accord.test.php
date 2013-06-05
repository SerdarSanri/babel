<?php
use Babel\Accord;
use Babel\Babel;

class FrenchAccordTests extends FrenchTests
{
  public function testAccordArticleNormal()
  {
    $babel = Babel::create()->article('the')->noun('category');

    $this->assertEquals("La catégorie", $babel->speak());
  }

  public function testAccordArticle()
  {
    $babel = Babel::create()->article('the')->noun('arbre');

    $this->assertEquals("L'arbre", $babel->speak());
  }

  public function testAccordWoman()
  {
    $babel = Babel::create()->article('a')->noun('category');

    $this->assertEquals("Une catégorie", $babel->speak());
  }
}