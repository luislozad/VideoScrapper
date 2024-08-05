<?php

namespace App\Livewire\Admin\Page;

use App\Models\SocialMedia;
use Livewire\Component;

class Social extends Component
{
    public $data = [];

    public function render()
    {
        return view('livewire.admin.page.social');
    }

    public function save(array $data)
    {
        try {
            $socialMedia = SocialMedia::first();
            if ($socialMedia) {
                $socialMedia->update(['data' => json_encode($data)]);
                flash()->addSuccess(__('Data was successfully updated'));
            } else {
                SocialMedia::create(['data' => json_encode($data)]);
                flash()->addSuccess(__('The data was saved successfully'));
            }
        } catch (\Throwable $th) {
            \Log::info($th);
            flash()->addError(__('An error occurred while saving data'));
        }
    }

    public function mount()
    {
        $this->initData();
    }

    public function initData()
    {
        try {
            $socialMedia = SocialMedia::first();
            if ($socialMedia) {
                $this->data = json_decode($socialMedia->data, true);
            }
        } catch (\Throwable $th) {
            \Log::info($th);
        }
    }
}
