<?php

namespace App\Livewire\Test;

use Livewire\Component;

class Counter extends Component
{
    public int $count = 0;

    public function increment()
    {
        $this->count++;
    }
    public function render()
    {
        return view('livewire.test.counter');
    }
}
