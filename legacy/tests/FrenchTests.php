<?php

abstract class FrenchTests extends BootstrapTests
{
  public static function setUpBeforeClass()
  {
    \Config::set('application.language', 'fr');
  }
}