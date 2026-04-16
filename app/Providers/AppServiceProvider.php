<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

class AppServiceProvider extends ServiceProvider
{
  /**
   * Register any application services.
   */
  public function register(): void
  {
    //
  }

  /**
   * Bootstrap any application services.
   */
  public function boot(): void
  {
    \Illuminate\Pagination\Paginator::useBootstrapFive();

    // Register both Livewire component namespaces
    \Livewire\Livewire::component('antenatal-record-list', \App\Livewire\AntenatalRecordList::class);

    // Auto-register all components in app/Livewire
    foreach (glob(app_path('Livewire/*.php')) as $file) {
      $class = 'App\\Livewire\\' . basename($file, '.php');
      $alias = \Illuminate\Support\Str::kebab(basename($file, '.php'));
      \Livewire\Livewire::component($alias, $class);
    }
  }
}
