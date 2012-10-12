<?php
use Babel\Babel;

class FrenchBabelTests extends FrenchTests
{
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
  public function testRestful($noun, $object, $verb, $state, $expected)
  {
    $babel = Babel::restful($noun, $object, $verb, $state);
    $expected = $this->wrapAlert($state, $expected);

    $this->assertEquals($expected, $babel);
  }

  public function testAdd()
  {
    $babel = Babel::add('user');

    $this->assertEquals('Ajouter un utilisateur', $babel);
  }

  public function testAddMultiple()
  {
    $babel = Babel::add('users');

    $this->assertEquals('Ajouter des utilisateurs', $babel);
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

  public function testOne()
  {
    $babel = Babel::many(1, 'album');

    $this->assertEquals('Un album affiché', $babel);
  }

  public function testMany()
  {
    $babel = Babel::many(12, 'category');

    $this->assertEquals('12 catégories affichées', $babel);
  }
}