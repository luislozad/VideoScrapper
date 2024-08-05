<?php

declare(strict_types=1);

namespace App\Livewire\Admin;

use App\Utils\Language;
use App\Utils\TranslateClientKey;
use Livewire\Component;

class ThemeContent extends Component
{
    use Language, TranslateClientKey;

    public $data = [];
    public $langCurrent = 'en';
    public $translateAPI = false;
    public $shortNames = [];
    // public $languages = [];

    public function render()
    {
        return view('livewire.admin.theme-content')->layout('layouts.admin');
    }

    public function mount()
    {
        $this->initData();
    }

    public function initData()
    {
        $this->initContent();
        $this->initLangCurrent();
        $this->initTranslateAPI();
        $this->initShortNames();
    }

    public function initShortNames()
    {
        $this->shortNames = self::getShortNames();
    }

    public function initTranslateAPI()
    {
        $this->translateAPI = $this->autoTranslateIsActive();
    }

    // public function initLanguages()
    // {
    //     $this->languages = self::getAllLanguages()->toArray();
    // }

    public function initLangCurrent()
    {
        $this->langCurrent = $this->getLanguageActive() ?? 'en';
    }

    public function initContent()
    {
        $this->data = $this->getLangData();
    }

    public function getLangData()
    {
        $data = [];
        $keys = [
            'Download HD videos',
            'Download videos from your favorite social media sites.',
            'Download Now',
            'Features',
            'Easy and fast',
            'Is the best tool to download video, images and audio from your favorite social media networks, completely free.',
            'Unlimited',
            'Save as many videos as you need, without limits.',
            'No watermark!',
            'Download videos from TikTok, Instagram or Facebook without watermark.',
            'MP4 and MP3',
            'Save videos in HD quality.',
        ];

        try {
            $languages = self::getAllLanguages();

            if ($languages->isEmpty()) {
                return [];
            }

            foreach ($languages as $lang) {
                $shortName = $lang->shortName;
                $langJSON = $this->getJsonLang($shortName);
                $content = [];

                foreach ($keys as $key) {
                    $content[$key] = $langJSON[$key];
                }

                // \Debugbar::info($content);

                $data[$shortName] = [
                    'content' => $content,
                    'icon' => $lang->icon,
                    'shortName' => $lang->shortName,
                    'fullName' => $lang->fullName,
                ];
            }

            return $data;
        } catch (\Throwable $th) {
            //throw $th;
            \Log::info("$th");
            return [];
        }
    }
}
