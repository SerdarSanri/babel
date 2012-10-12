<?php
use Babel\Accord;

include 'start.php';
include 'EnglishTests.php';
include 'FrenchTests.php';

class EnglishAccordTests extends EnglishTests
{
  public function testAccordArticleNormal()
  {
    $babel = Accord::articleToNoun('pear', 'a');

    $this->assertEquals("a", $babel);
  }

  public function testAccordArticle()
  {
    $babel = Accord::articleToNoun('apricot', 'a');

    $this->assertEquals("an", $babel);
  }
}