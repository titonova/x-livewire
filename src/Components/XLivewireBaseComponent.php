<?php

namespace Titonova\XLivewire\Components;

use Livewire\Component;

class XLivewireBaseComponent extends Component
{

    public $slot;
    public $attributes;
    public $isXLivewireView = true;

    public function slot()
    {
        return unserialize($this->slot);
    }

    public function attributes()
    {
        return unserialize($this->attributes);
    }

}
