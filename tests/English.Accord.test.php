<?php
use Babel\Accord;
use Babel\Message;

include 'start.php';
include 'EnglishTests.php';
include 'FrenchTests.php';

class EnglishAccordTests extends EnglishTests
{
  public function testAccordArticleNormal()
  {
    $message = Message::start('pear');
    $babel = Accord::article('a', $message);

    $this->assertEquals("a", $babel);
  }

  public function testAccordArticle()
  {
    $message = Message::start('apricot');
    $babel = Accord::article('a', $message);

    $this->assertEquals("an", $babel);
  }
}