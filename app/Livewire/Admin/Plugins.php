<?php

namespace App\Livewire\Admin;

use Livewire\Component;

class Plugins extends Component
{
    public function render()
    {
        return view('livewire.admin.plugins')->layout('layouts.admin');
    }
}
