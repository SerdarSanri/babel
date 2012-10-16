<?php

abstract class SpanishTests extends BootstrapTests
{
  public static function setUpBeforeClass()
  {
    \Config::set('application.language', 'sp');
  }
}