<?php
use Babel\Babel;

class FrenchVerbTest extends FrenchTests
{
  public function testIrregular()
  {
    $babel = Babel::create()->article('the')->noun('document')->verb('submit')->speak();

    $this->assertEquals('Le document a été soumis', $babel);
  }
}