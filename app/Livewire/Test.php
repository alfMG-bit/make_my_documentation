<?php

namespace App\Livewire;

use Livewire\Component;

class Test extends Component
{
    public $variable = "Test";

    public function render()
    {
        return view('livewire.test');
    }

    public function updateVariable($value)
    {
        $this->variable = $value;
    }
}
