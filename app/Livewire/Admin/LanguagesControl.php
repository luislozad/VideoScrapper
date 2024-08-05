<?php

namespace App\Livewire\Admin;

use App\Models\Language as ModelsLanguage;
use Livewire\Component;

class LanguagesControl extends Component
{
    public $languages = [];
    public $shortNames = [];
    public $enabledLanguages = [];
    public $languageCurrent;

    public function render()
    {
        return view('livewire.admin.languages-control')->layout('layouts.admin');
    }

    public function mount()
    {
        $this->initData();
    }

    public function initData()
    {
        $languages = [];
        $shortNames = [];
        $enabledLanguages = [];
        $languageCurrent = 'en';

        try {
            $languagesDB = ModelsLanguage::all();
            foreach ($languagesDB as $lang) {
                $languages[$lang->shortName] = $lang;
                $shortNames[] = $lang->shortName;

                if ($lang->enabled) {
                    $enabledLanguages[] = $lang->shortName;
                }

                if ($lang->active) {
                    $languageCurrent = $lang->shortName;;
                }
            }
        } catch (\Throwable $th) {
            //throw $th;
            \Log::info("initData: $th");
        }

        // \Debugbar::info($languages);

        $this->languages = $languages;
        $this->shortNames = $shortNames;
        $this->enabledLanguages = $enabledLanguages;
        $this->languageCurrent = $languageCurrent;
    }

    public function save(array $langs)
    {
        try {
            $languages = ModelsLanguage::all();

            foreach ($languages as $lang) {
                $langData = $langs[$lang->shortName];
                $isEnabled = $langData['enabled'];
                $isActive = $langData['active'];
                $lang->enabled = $isEnabled;
                $lang->active = $isActive;
                $lang->save();
            }
            flash()->addSuccess(__('The data was saved successfully'));
        } catch (\Throwable $th) {
            //throw $th;
            \Log::info("save languages: $th");
            flash()->addError(__('An error occurred while saving data'));
        }
    }
}
