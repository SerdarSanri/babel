<?php
use Babel\Babel;

class FrenchBabelTests extends FrenchTests
{
  public static function setUpBeforeClass()
  {
    \Config::set('application.language', 'fr');
  }

  public function restful()
  {
    return array(
      array('category', 'foo', 'create', true,  'La catégorie &laquo; foo &raquo; a bien été créée'),
      array('user',     'foo', 'delete', false, 'L\'utilisateur &laquo; foo &raquo; n\'a pas pu être supprimé'),
    );
  }

  /**
   * @dataProvider restful
  */
  public function testRestful($page, $object, $verb, $state, $expected)
  {
    $babel = Babel::restful($page, $object, $verb, $state);
    $expected = $this->wrapAlert($state, $expected);

    $this->assertEquals($expected, $babel);
  }

  public function testAdd()
  {
    $babel = Babel::add('user');

    $this->assertEquals('Ajouter un utilisateur', $babel);
  }

  public function testAddAccord()
  {
    $babel = Babel::add('category');

    $this->assertEquals('Ajouter une catégorie', $babel);
  }

  public function testNothing()
  {
    $babel = Babel::nothing('user');

    $this->assertEquals('Aucun utilisateur à afficher', $babel);
  }
}