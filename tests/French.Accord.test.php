<?php
use Babel\Accord;

class FrenchAccordTests extends FrenchTests
{
  public static function setUpBeforeClass()
  {
    \Config::set('application.language', 'fr');
  }

  public function testAccordArticleApostropheNormal()
  {
    $babel = Accord::articleToNoun('poire', 'la');

    $this->assertEquals("la", $babel);
  }

  public function testAccordArticleApostrophe()
  {
    $babel = Accord::articleToNoun('arbre', 'le');

    $this->assertEquals("l'", $babel);
  }
}