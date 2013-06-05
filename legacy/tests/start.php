<?php
Bundle::start('babel');

abstract class BootstrapTests extends PHPUnit_Framework_TestCase
{
  // Wrappers ------------------------------------------------------ /

  public function wrapAlert($state, $text)
  {
    return $state
      ? '<div class="alert alert-success">' .$text. '</div>'
      : '<div class="alert alert-error">'   .$text. '</div>';
  }
}
