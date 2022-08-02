<?php

namespace Titonova\XLivewire\Components;

use Illuminate\View\Component;

class Livewire extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('x-livewire::components.livewire');
    }
}
