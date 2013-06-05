<?php
use Babel\Babel;

class SentenceTest extends BaseTests
{
	public function testCanGetBlueprintsOfSentences()
	{
		$sentence = Babel::sentence()->subject('I')->verb('eat', 'past')->number(3)->noun('apple');

		$this->assertEquals('["Subject","Word","Word","Noun"]', $sentence->getBlueprint());
	}
}