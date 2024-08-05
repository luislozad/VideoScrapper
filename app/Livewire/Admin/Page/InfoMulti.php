<?php

namespace App\Livewire\Admin\Page;

use App\Models\Language;
use App\Utils\Language as UtilsLanguage;
use App\Utils\TranslateClientKey;
use Livewire\Component;

class InfoMulti extends Component
{
    use UtilsLanguage, TranslateClientKey;

    public string $langCurrent;
    public array $langData;

    public function render()
    {
        return view('livewire.admin.page.info-multi');
    }

    public function mount()
    {
        $this->initData();
    }

    public function getLangData()
    {
        $languages = self::getAllLanguages();

        $langData = [];

        foreach ($languages as $lang) {
            $shortName = $lang->shortName;
            $languageJSON = $this->getJsonLang($shortName);
            $langData[$shortName] = [
                'title' => $languageJSON['Website title'] ?? '',
                'description' => $languageJSON['Website description'] ?? '',
                'keywords' => $languageJSON['Website keywords'] ?? '',
            ];
        }

        return $langData;
    }

    public function initData()
    {

        $this->langData = $this->getLangData();
        $this->langCurrent = $this->getLanguageActive() ?? 'en';
    }
}
