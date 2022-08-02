<?php

namespace Titonova\XLivewire;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Titonova\XLivewire\Commands\XLivewireCommand;

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
            ->hasMigration('create_x-livewire_table')
            ->hasCommand(XLivewireCommand::class);
    }
}
