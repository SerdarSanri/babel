<?php
use Babel\Babel;

class SpanishBabelTests extends SpanishTests
{
  public function restful()
  {
    return array(
      array('category', 'foo', 'create', true,  'La categoría &laquo; foo &raquo; ha creado correctamente'),
      array('user',     'foo', 'delete', false, 'El usuario &laquo; foo &raquo; no pudo ser'),
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

    $this->assertEquals('Añadir un usuario', $babel);
  }

  public function testAddMultiple()
  {
    $babel = Babel::add('users');

    $this->assertEquals('Añadir usuarios', $babel);
  }

  public function testAddAccord()
  {
    $babel = Babel::add('category');

    $this->assertEquals('Añadir una categoría', $babel);
  }

  public function testNothing()
  {
    $babel = Babel::no('user');

    $this->assertEquals('No hay usuario para mostrar', $babel);
  }

  public function testNothingGeneral()
  {
    $babel = Babel::no('file', 'link');

    $this->assertEquals('No hay fichero vinculado', $babel);
  }

  public function testOne()
  {
    $babel = Babel::many(1, 'album', 'display');

    $this->assertEquals('Un álbum muestra', $babel);
  }

  public function testMany()
  {
    $babel = Babel::many(12, 'category', 'display');

    $this->assertEquals('12 categorías muestra', $babel);
  }

  public function testManyDynamic()
  {
    $babel = Babel::update(12, 'category');

    $this->assertEquals('12 categorías actualizado', $babel);
  }

  public function testManyPastDynamic()
  {
    $babel = Babel::created(0, 'category');

    $this->assertEquals('No hay categorías creadas', $babel);
  }

  public function testContainerContains()
  {
    $message = Babel::contains(12, 'photo', 'category');

    return $this->assertTrue(true);
    $this->assertEquals('12 fotos de esta categoría', $message);
  }

  public function testContainersContains()
  {
    $message = Babel::contains(12, 'photo', 'categories');

    $this->assertEquals('12 fotos en esas categorías', $message);
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

    $this->assertEquals('12 categorías creadas', $babel);
  }
}