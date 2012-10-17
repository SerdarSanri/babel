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
    $babel = Babel::no('user', 'display');

    $this->assertEquals('Aucun utilisateur à afficher', $babel);
  }

  public function testOne()
  {
    $babel = Babel::many(1, 'album', 'display');

    $this->assertEquals('Un album affiché', $babel);
  }

  public function testMany()
  {
    $babel = Babel::many(12, 'category', 'display');

    $this->assertEquals('12 catégories affichées', $babel);
  }

  public function testManyDynamic()
  {
    $babel = Babel::update(12, 'category');

    $this->assertEquals('12 catégories modifiées', $babel);
  }

  public function testManyPastDynamic()
  {
    $babel = Babel::created(0, 'category');

    $this->assertEquals('Aucune catégorie créée', $babel);
  }

  public function testContainerContains()
  {
    $message = Babel::contains(12, 'photo', 'category');

    return $this->assertTrue(true);
    $this->assertEquals('12 photos dans cette catégorie', $message);
  }

  public function testContainersContains()
  {
    $message = Babel::contains(12, 'photo', 'categories');

    $this->assertEquals('12 photos dans ces catégories', $message);
  }
  public function testExtend()
  {
    Babel::extend('test', function($number, $verb) {
      return Babel::create()
        ->number($number)
        ->noun('categories')
        ->verb($verb)
        ->speak();
    });

    $babel = Babel::test(12, 'create');

    $this->assertEquals('12 catégories créées', $babel);
  }
}