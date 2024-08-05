<?php

namespace App\Utils;

use App\Models\GoogleCloudTranslationApi;
use App\Models\Language as ModelsLanguage;
use Illuminate\Support\Facades\File;
use Google\Cloud\Translate\V2\TranslateClient;

trait Language
{
    public function getJsonLang(string $lang)
    {
        $file = base_path("lang/{$lang}.json");

        if (!File::exists($file)) return null;

        $jsonContent = File::get($file);

        $langData = json_decode($jsonContent, true, 512, JSON_UNESCAPED_UNICODE);

        return $langData;
    }

    public function updateJsonLang(string $lang, array $data)
    {
        $language = $this->getJsonLang($lang);

        $langPath = "lang/{$lang}.json";

        if (!$language) return false;

        foreach ($data as $key => $value) {
            $language[$key] = $value;
        }

        $languageJson = json_encode($language, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

        File::put(base_path($langPath), $languageJson);

        return true;
    }

    public function autoTranslateIsActive(): bool
    {
        $cloudTranslate = GoogleCloudTranslationApi::first();

        if (!$cloudTranslate) return false;

        if (empty($cloudTranslate->key)) return false;

        return true;
    }

    public function autoTranslate(array $data)
    {
        try {
            $langFrom = $data['langFrom'];
            $langTo = $data['langTo'];

            $translate = $data['translate'];

            $jsonLang = [];

            $isTranslated = true;

            $translationClient = $this->getTranslateClient();

            if (!$translationClient) return;

            // \Debugbar::info($translate);

            foreach ($translate as $key => $value) {
                $result = $translationClient->translate($value, [
                    'source' => $langFrom,
                    'target' => $langTo
                ]);

                if ($result === null) {
                    $isTranslated = false;
                    break;
                };

                $jsonLang[$key] = $result['text'];
            }

            if (!$isTranslated) {
                return false;
            }

            return $this->updateJsonLang($langTo, $jsonLang);
        } catch (\Throwable $th) {
            \Log::info("autoTranslate: $th");
            return false;
        }
    }

    public function saveTranslate(array $data)
    {
        try {
            return $this->updateJsonLang($data['lang'], $data['translate']);
        } catch (\Throwable $th) {
            \Log::info("saveTranslate: $th");
            return false;
        }
    }

    public function getLanguageActive(): ?string
    {
        try {
            $languages = ModelsLanguage::all();

            $langActive = null;

            if ($languages->isEmpty()) return $langActive;

            foreach ($languages as $lang) {
                if ($lang->active) {
                    $langActive = $lang->shortName;
                    break;
                }
            }

            return $langActive;
        } catch (\Throwable $th) {
            //throw $th;
            \Log::info("getLanguageAtive: $th");

            return null;
        }
    }

    public static function getActiveLang(): ?string
    {
        try {
            $languages = ModelsLanguage::all();

            $langActive = null;

            if ($languages->isEmpty()) return $langActive;

            foreach ($languages as $lang) {
                if ($lang->active) {
                    $langActive = $lang->shortName;
                    break;
                }
            }

            return $langActive;
        } catch (\Throwable $th) {
            //throw $th;
            \Log::info("getLanguageAtive: $th");

            return null;
        }
    }

    public static function getAllLanguages()
    {
        $languages = ModelsLanguage::all()
            ->filter(function ($lang) {
                return $lang->enabled === 1;
            });

        return  $languages;
    }

    public static function getShortNames()
    {
        $languages = self::getAllLanguages();

        if ($languages->isEmpty()) return [];

        $langShortNames = $languages
            ->map(function ($lang) {
                return $lang->shortName;
            })
            ->values()->toArray();

        return $langShortNames;
    }

    abstract protected function getTranslateClient(): ?TranslateClient;
}
