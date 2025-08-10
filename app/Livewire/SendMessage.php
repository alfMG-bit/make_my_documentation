<?php

namespace App\Livewire;

use Livewire\Component;

class SendMessage extends Component
{
    public $message = "";

    public function render()
    {
        return view('livewire.send-message');
    }

    public function sendMessage()
    {
        $toSend = $this->message;
        $this->dispatch("mes", compact("toSend"));
    }
}
