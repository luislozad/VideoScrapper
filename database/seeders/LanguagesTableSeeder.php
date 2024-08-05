<?php

namespace Database\Seeders;

use App\Models\Language;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LanguagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Language::truncate();

        Language::create([
            'fullName' => 'English',
            'shortName' => 'en',
            'icon' => 'flag-country-us',
            'active' => true,
            'enabled' => true,
        ]);

        Language::create([
            'fullName' => 'Français',
            'shortName' => 'fr',
            'icon' => 'flag-country-fr',
            'active' => false,
            'enabled' => true,
        ]);

        Language::create([
            'fullName' => 'Español',
            'shortName' => 'es',
            'icon' => 'flag-country-es',
            'active' => false,
            'enabled' => true,
        ]);

        Language::create([
            'fullName' => 'العربية',
            'shortName' => 'ar',
            'icon' => 'flag-country-sa',
            'active' => false,
            'enabled' => true,
        ]);

        Language::create([
            'fullName' => 'Português',
            'shortName' => 'pt',
            'icon' => 'flag-country-br',
            'active' => false,
            'enabled' => true,
        ]);

        Language::create([
            'fullName' => 'Deutsch',
            'shortName' => 'de',
            'icon' => 'flag-country-de',
            'active' => false,
            'enabled' => true,
        ]);

        Language::create([
            'fullName' => 'Italiano',
            'shortName' => 'it',
            'icon' => 'flag-country-it',
            'active' => false,
            'enabled' => true,
        ]);

        Language::create([
            'fullName' => 'Türkçe',
            'shortName' => 'tr',
            'icon' => 'flag-country-tc',
            'active' => false,
            'enabled' => true,
        ]);

        Language::create([
            'fullName' => 'Русский',
            'shortName' => 'ru',
            'icon' => 'flag-country-ru',
            'active' => false,
            'enabled' => true,
        ]);

        Language::create([
            'fullName' => 'हिन्दी',
            'shortName' => 'hi',
            'icon' => 'flag-country-in',
            'active' => false,
            'enabled' => true,
        ]);

        Language::create([
            'fullName' => 'বাংলা',
            'shortName' => 'bn',
            'icon' => 'flag-country-bd',
            'active' => false,
            'enabled' => true,
        ]);

        Language::create([
            'fullName' => '简体中文',
            'shortName' => 'zh',
            'icon' => 'flag-country-cn',
            'active' => false,
            'enabled' => true,
        ]);

        Language::create([
            'fullName' => '日本語',
            'shortName' => 'ja',
            'icon' => 'flag-country-jp',
            'active' => false,
            'enabled' => true,
        ]);

        Language::create([
            'fullName' => 'עִברִית',
            'shortName' => 'he',
            'icon' => 'flag-country-il',
            'active' => false,
            'enabled' => true,
        ]);

        Language::create([
            'fullName' => 'ไทย',
            'shortName' => 'th',
            'icon' => 'flag-country-th',
            'active' => false,
            'enabled' => true,
        ]);

        Language::create([
            'fullName' => 'Română',
            'shortName' => 'ro',
            'icon' => 'flag-country-ro',
            'active' => false,
            'enabled' => true,
        ]);

        Language::create([
            'fullName' => 'ქართული',
            'shortName' => 'ka',
            'icon' => 'flag-country-ge',
            'active' => false,
            'enabled' => true,
        ]);
    }
}
