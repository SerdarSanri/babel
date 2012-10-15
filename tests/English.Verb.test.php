<?php
use Babel\Babel;

class EnglishVerbTest extends EnglishTests
{
  public function testSubmit()
  {
    $babel = Babel::create()->article('the')->noun('document')->verb('submit')->speak();

    $this->assertEquals('The document was submitted', $babel);
  }
}