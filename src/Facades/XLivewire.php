<?php

namespace Titonova\XLivewire\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Titonova\XLivewire\XLivewire
 */
class XLivewire extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Titonova\XLivewire\XLivewire::class;
    }
}
