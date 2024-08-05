<?php

namespace App\Livewire\Admin;

use Livewire\Attributes\Validate;
use Livewire\Component;

class UpdateControl extends Component
{

    #[Validate('required')]
    public $file;

    public function render()
    {
        return view('livewire.admin.update-control')->layout('layouts.admin');
    }

    public function unzip()
    {
        if (class_exists('ZipArchive')) {

            $filePath = $this->file->store('zip');

            //Unzip uploaded update file and remove zip file.
            $zip = new \ZipArchive;

            $fullPath = base_path('storage/app/' . $filePath);

            $res = $zip->open($fullPath);

            if ($res === true) {
                $res = $zip->extractTo(base_path());
                $zip->close();

                unlink($fullPath);
            } else {
                $this->addError('file', 'Could not open the updates zip file.');
            }
        } else {
            $this->addError('ZipArchive', 'Please enable ZipArchive extension.');
        }
    }
}
