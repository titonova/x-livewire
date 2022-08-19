<?php

namespace Titonova\XLivewire;

use Illuminate\Support\Facades\Blade;
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
            //->hasMigration('create_x-livewire_table')
            ->hasCommand(XLivewireCommand::class);
    }


    public function bootingPackage()
    {
        Blade::directive('setUpXLivewire', function ($expression) {
            return '<?php

            $attributes = $this->attributes();

            /**
             *  This is9would be) an array of all attributes that were set in the x-livewire tag
             *  But were not declared in the component class.
             *
             */

            $this->tagAttributes = [];

            if($attributes instanceof \Illuminate\View\ComponentAttributeBag){
                $slot =   $this->slot()->toHtml() ;

             /**
                 * Loop through all the attributes passed in the livewire tag
                 * and make them variables and class properties to be used in the
                 * view and livewire component.
                 */

                    foreach($attributes as $key=>$value){
                        if(\Titonova\XLivewire\XLivewire::propertyIsPublic($key,$this)){
                                $this->$key= $$key = $value;
                        }

                        /**
                         *  Get all the attributes that were written but arent meant to be properties.
                         */
                        $camelKey = Str::camel($key);
                        if(!(\Titonova\XLivewire\XLivewire::propertyIsPublic($camelKey,$this)) && $key !=="_"){
                            $this->tagAttributes[$key]=$value;
                        }
                        unset($key, $value);
                    }
            }
            ?>';
        });
    }

}
