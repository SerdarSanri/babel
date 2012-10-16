<?php
use Babel\Accord;
use Babel\Babel;

include 'start.php';
include 'EnglishTests.php';
include 'FrenchTests.php';
include 'SpanishTests.php';

class EnglishAccordTests extends EnglishTests
{
  public function testAccordArticleNormal()
  {
    $babel = Babel::create()->article('a')->noun('category');

    $this->assertEquals('A category', $babel->speak());
  }

  public function testAccordArticle()
  {
    $babel = Babel::create()->article('a')->noun('apricot');

    $this->assertEquals('An apricot', $babel->speak());
  }
}