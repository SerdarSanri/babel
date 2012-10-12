<?php
use Babel\Accord;
use Babel\Babel;

include 'start.php';
include 'EnglishTests.php';
include 'FrenchTests.php';

class EnglishAccordTests extends EnglishTests
{
  public function testAccordArticleNormal()
  {
    $message = Babel::create('pear');
    $babel = Accord::article('a', $message);

    $this->assertEquals("a", $babel);
  }

  public function testAccordArticle()
  {
    $message = Babel::create('apricot');
    $babel = Accord::article('a', $message);

    $this->assertEquals("an", $babel);
  }
}