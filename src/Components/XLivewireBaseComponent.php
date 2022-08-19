<?php

namespace Titonova\XLivewire\Components;

use Livewire\Component;
use Illuminate\Support\Str;

class XLivewireBaseComponent extends Component
{

    public $slot;
    public $attributes;

    public function slot()
    {
        return unserialize($this->slot);
    }

    public function attributes()
    {
        return unserialize($this->attributes);
    }

    public function setProps()
    {
        // We name it this way to avoid conflicts with the component's own $attributes property.
        $this->attributesCollection =  collect($this->attributes());

        // Get a collection  the names of all the public properties.
        $r_object = new \ReflectionObject($this);
        $public_props = collect($r_object->getProperties(\ReflectionProperty::IS_PUBLIC))->transform(fn($prop) => $prop->name);

        /**
         * Loop through all the public properties of the x-livewire component and initialize their value
         * by setting to the snake-hypen case of their value from the $attributes array,
         * or if it wasnt explicitedly set, use the default value;
         *
         * e.g `$this->propName = $this->attributes('prop-name');`
         */
        foreach ($public_props as $prop) {
            // We need to ensure that the current property name we are looping through isn't
            // 'attributes' or else it will be overriden and set to null :(.
            // Which would render the $attributes variable useless
            if(!in_array($prop,['attributes'])){

                // The name of the property we are looping through, in snake-hypen case.
                // This is the name of the property component's backend
                $prop_livewire_name =  Str::snake($prop,'-');

                // Check if the property was explicitely set in the $attributes array.
                if($this->attributesCollection->has($prop_livewire_name)){

                    // If it was explicitely set, set the property to the value from the $attributes array.
                    $this->$prop =  $this->attributesCollection->get($prop_livewire_name);
                }
            }
        }


    }

}
