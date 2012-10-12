<?php

abstract class EnglishTests extends BootstrapTests
{
  public static function setUpBeforeClass()
  {
    \Config::set('application.language', 'en');
  }

}