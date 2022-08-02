<?php

namespace Titonova\XLivewire;

use Spatie\LaravelPackageTools\Package;
use Titonova\XLivewire\Components\Livewire;
use Titonova\XLivewire\Commands\XLivewireCommand;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class XLivewireServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('x-livewire')
            ->hasConfigFile()
            ->hasViews()
            ->hasViewComponents('',Livewire::class)
            ->hasMigration('create_x-livewire_table')
            ->hasCommand(XLivewireCommand::class);
    }


}
