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
    $babel = Babel::nothing('user');

    $this->assertEquals('No user to display', $babel);
  }

}
