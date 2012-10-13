<?php
use Babel\Babel;

class EnglishBabelTests extends EnglishTests
{
  public function restful()
  {
    return array(
      array('category', 'foo', 'create', true,  'The category &laquo; foo &raquo; has been successfully created'),
      array('user',     'foo', 'delete', false, 'The user &laquo; foo &raquo; couldn\'t be deleted'),
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

    $this->assertEquals('Add an user', $babel);
  }

  public function testAddMultiple()
  {
    $babel = Babel::add('users');

    $this->assertEquals('Add users', $babel);
  }

  public function testAddAccord()
  {
    $babel = Babel::add('category');

    $this->assertEquals('Add a category', $babel);
  }

  public function testNothing()
  {
    $babel = Babel::no('user');

    $this->assertEquals('No user to display', $babel);
  }

  public function testOne()
  {
    $babel = Babel::many(1, 'album');

    $this->assertEquals('One album displayed', $babel);
  }

  public function testMany()
  {
    $babel = Babel::many(12, 'category');

    $this->assertEquals('12 categories displayed', $babel);
  }

  public function testManyDynamic()
  {
    $babel = Babel::update(12, 'category');

    $this->assertEquals('12 categories updated', $babel);
  }

  public function testManyPastDynamic()
  {
    $babel = Babel::created(0, 'category');

    $this->assertEquals('No category created', $babel);
  }

}
