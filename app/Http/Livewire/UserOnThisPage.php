<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Broadcast;
use Livewire\Component;

class UserOnThisPage extends Component
{

    public $usersOnPage = [];

    public function render()
    {
        return view('livewire.user-on-this-page', $this->usersOnPage);
    }
}
