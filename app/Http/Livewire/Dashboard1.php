<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Attendance; 
use Illuminate\Support\Facades\Auth;

class Dashboard1 extends Component
{
    public $attendances;

    public function mount()
    {
        // Fetch the attendance data for the logged-in user
        $this->attendances = Attendance::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();
    }
    
    public function render()
    {
        return view('livewire.staff.dashboard1');
    }
}
