<?php
namespace Babel;

use Illuminate\Support\ServiceProvider;

class BabelServiceProvider extends ServiceProvider
{
  /**
   * Indicates if loading of the provider is deferred.
   *
   * @var bool
   */
  protected $defer = false;

  /**
   * Bootstrap the application events.
   *
   * @return void
   */
  public function boot()
  {
    $this->package('anahkiasen/babel');
  }

  /**
   * Register the service provider.
   *
   * @return void
   */
  public function register()
  {
    //
  }

  /**
   * Get the services provided by the provider.
   *
   * @return array
   */
  public function provides()
  {
    return array();
  }
}