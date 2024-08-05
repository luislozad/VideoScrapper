<?php

namespace App\Livewire\Admin;

use Livewire\Component;

class Themes extends Component
{
    public function render()
    {
        return view('livewire.admin.themes')->layout('layouts.admin');
    }
}
