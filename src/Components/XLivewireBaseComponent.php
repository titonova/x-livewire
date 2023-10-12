<?php

namespace Titonova\XLivewire\Components;

use Livewire\Component;
use Illuminate\Support\Str;

class XLivewireBaseComponent extends Component
{

    public string $slot;
    protected string $_slot = '';

    public string $_attributes;
    protected string $__attributes = '';


    /**
     * The serialized array of custom slots passed to the component.
     * Basically, x-livewire's version of the default Blade $__laravel_slot variable.
     *
     *
     * @var string
     */
    public string $laravelSlots;
    protected string $_laravelSlots = '';

    public function slot()
    {
        return unserialize($this->_slot);
    }

    public function attributes()
    {
        return unserialize($this->__attributes);
    }

    public function laravelSlots()
    {
        return unserialize($this->_laravelSlots);
    }


    public function mount(){
        $this->setProps();
    }

    /**
     * Set the component's class properties from the attributes passed into it's x-livewire tag.
     *
     * What this method does is loop through all it's public properties and set them to the values given in the tag.
     * If the property is not public, it is added to the $tagAttributes array.
     *
     * E.g: Let's say  we have an x-livewire tag as follows:
     * <x-livewire: _="my-component" :my-attribute="my-value" another-attribute="foofoo" my-tag-attribute="dont-add-me" />
     * And its component class is defined as follows:
     * class MyComponent extends XLivewireBaseComponent{... public $myAttribute; public $anotherAttribute; ...}
     *
     * In this case, the component will have the following properties set:
     * $this->myAttribute = "my-value"
     * $this->anotherAttribute = "foofoo"
     *
     * There won't be any properties set for the `my-tag-attribute`, as there was no public property with that name($myTagAttribute).
     * It would have been added to the $tagAttributes array instead.
     * To access it, you would use the following code:
     * $this->tagAttributes["my-tag-attribute"]
     *
     * This method should be the first method called in the component's `mount()` method.
     *
     * @return void
     */
    public function setProps(): void
    {
        $this->__attributes = $this->_attributes;
        $this->_slot = $this->slot;
        $this->_laravelSlots = $this->laravelSlots;

        $attributes = $this->attributes();//->getAttributes();

        // The collection of all attributes that were set in the x-livewire tag.
        // We name it this way to avoid conflicts with the component's actual  $attributes property.
        $this->attributesCollection =  collect($attributes);

        // Get a collection of the names of all the public properties.
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

                // Check if the property was explicitely set in the $attributes array....
                if($this->attributesCollection->has($prop_livewire_name)){

                    // ...If the property was explicitely set, set the property to the value from the $attributes array.
                    $this->$prop =  $this->attributesCollection->get($prop_livewire_name);
                }
            }
        }

        // To hide all these properties from the frontend, we unset them.
        unset($this->_attributes, $this->laravelSlots, $this->slot);


    }

}
