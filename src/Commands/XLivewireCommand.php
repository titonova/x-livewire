<?php

namespace Titonova\XLivewire\Commands;

use Illuminate\Console\Command;

class XLivewireCommand extends Command
{
    public $signature = 'x-livewire';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
