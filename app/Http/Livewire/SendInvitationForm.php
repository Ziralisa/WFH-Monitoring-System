<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Mail;
use App\Mail\InvitationEmail;
use App\Models\Invitation;
use Illuminate\Support\Str;
use Livewire\Component;

class SendInvitationForm extends Component
{   

    public string $email = '';

    public function sendInvitation()
    {
        $this->validate([
            'email' => 'required|email|unique:invitations,email',
        ]);
  
        $invitation = Invitation::create([
            'email' => $this->email,
            'token' => \Str::random(32),
            'company_id' => auth()->user()->company_id,
            'expired_at' => now()->addDays(7),
        ]);

        Mail::to($this->email)->send(new InvitationEmail($invitation));
        session()->flash('message', 'Invitation sent successfully!');
        $this->reset(['email']);
       
    }

    public function render()
    {
        return view('livewire.send-invitation-form');
    }
}
