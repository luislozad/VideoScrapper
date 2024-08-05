<?php

namespace App\Livewire\Admin;

use App\Models\GoogleCloudTranslationApi;
use Livewire\Attributes\Validate;
use Livewire\Component;

class TranslateApiControl extends Component
{
    #[Validate('string|required')]
    public $key;

    public function render()
    {
        return view('livewire.admin.translate-api-control')->layout('layouts.admin');
    }

    public function save()
    {
        try {
            $cloudApi = GoogleCloudTranslationApi::first();

            if ($cloudApi) {
                $cloudApi->update(['key' => $this->key]);
                flash()->addSuccess(__('The key was successfully updated.'));
                return;
            }

            GoogleCloudTranslationApi::create(['key' => $this->key]);

            flash()->addSuccess(__('The key was successfully created.'));
        } catch (\Throwable $th) {
            flash()->addError(__('There was an error when saving the api key.'));
            \Log::info($th);
        }
    }

    public function mount()
    {
        $this->init();
    }

    public function init()
    {
        try {
            $cloudApi = GoogleCloudTranslationApi::first();

            if ($cloudApi) {
                $this->key = $cloudApi->key;
            }
        } catch (\Throwable $th) {
            //throw $th;
            \Log::info($th);
        }
    }
}
