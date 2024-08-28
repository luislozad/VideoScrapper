<?php

namespace App\Livewire\Admin\Plugins;

use Livewire\Component;

class MediaDownloader extends Component
{
    public function render()
    {
        return view('livewire.admin.plugins.media-downloader')->layout('layouts.admin');
    }
}
