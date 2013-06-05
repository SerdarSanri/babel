<?php

class BabelTest extends BaseTests
{

	public function testCanGetClassesFromBabel()
	{
		$class = $this->babel->accordNumber;

		$this->assertInstanceOf('Babel\Accorder\Number', $class);
	}

}