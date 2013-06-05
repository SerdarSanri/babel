<?php
include 'BaseTests.php';

class AccorderNumberTest extends BaseTests
{
	public function testCanAccordToNumber()
	{
		$this->assertEquals('3 words', $this->babel->accordNumber->accord('word', 3));
	}
}