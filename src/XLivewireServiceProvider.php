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
             *  This is would be an array of all attributes that were set in the x-livewire tag
             *  But were not declared in the component class.
             *
             *
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
                /**
                 *  Extract the (named) slot values from the $__laravel_slot variable.
                 *  Thus allowing access to custom, named slots in the view.
                 *
                 *  That is, Loop through all the slots in the $laraveSlots array and set the property name to the
                 *  camel case version of the slot name and the value to the slot value.
                 *
                 *  If the slot value is an empty string, it will be set to null so that null checks
                 *
                 *
                 */
                foreach ($this->laravelSlots() as $slot_name => $slot_value) {
                    if($slot_name !=="__default"){
                        ${Str::camel($slot_name)} = $slot_value->toHtml() == "" ? null : $slot_value->toHtml();
                    }


                }



                /**
                 * Allow $tagAttributes to be accessed from the view.
                 * e.g {{ $tagAttributes["my-tag-attribute"] }}
                 */

                $tagAttributes = $this->tagAttributes;

                /**
                 * Clean up unneccessary variables that were set
                 */
                unset($slot_name, $slot_value, $camelKey);

            }
            ?>';
        });
    }

}
