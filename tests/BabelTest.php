<?php
use Babel\Babel;

class BabelTest extends BaseTests
{

	public function testCanGetClassesFromBabel()
	{
		$class = $this->babel->accordNumber;

		$this->assertInstanceOf('Babel\Accorder\Number', $class);
	}

	public function testCanCreateSentenceInstanceStatically()
	{
		$this->assertInstanceOf('Babel\Sentence\Sentence', Babel::sentence());
	}

	// Sentences tests ----------------------------------------------- /

	public function testSentenceOne()
	{
		$sentence = Babel::sentence()->subject('I')->verb('eat', 'past')->number(3)->noun('apple');

		$this->assertEquals('I ate 3 apples', $sentence->speak());
	}

}