<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Utils\Language;
// use Codezero\BrowserLocale\BrowserLocale;

class GeoLanguage
{
    private Response $response;

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Obtener una instancia de BrowserLocale desde el contenedor de servicios de Laravel
        $browser = \App::make(\CodeZero\BrowserLocale\BrowserLocale::class);
        $locale = $browser->getLocale();

        // Obtener el idioma preferido del navegador
        $browserLanguage = $locale ? $locale->language : null;

        $languages = $this->getShortLang();

        $lang = $request->query('lang');
        $languagePreference = $request->cookie('language_preference');

        $defaultLang = $this->getDefaultLang();

        if ($lang && in_array($lang, $languages)) {
            app()->setLocale($lang);
            $this->response = $this->saveLanguagePreference($request, $next, $lang);
        } elseif (in_array($languagePreference, $languages)) {
            app()->setLocale($languagePreference);
            $this->response = $this->saveLanguagePreference($request, $next, $languagePreference);
        } elseif ($browserLanguage && in_array($browserLanguage, $languages)) {
            app()->setLocale($browserLanguage);
            $this->response = $this->saveLanguagePreference($request, $next, $browserLanguage);
        } else {
            app()->setLocale($defaultLang);
            $this->response = $this->saveLanguagePreference($request, $next, $defaultLang);
        }

        return $this->response;
    }

    private function saveLanguagePreference(Request $request, Closure $next, string $lang): Response
    {
        $response = $next($request);
        $cookie = cookie('language_preference', $lang, 60 * 24 * 30);
        $response->headers->setCookie($cookie);

        return $response;
    }

    private function getShortLang(): array
    {
        $languages = [];

        try {
            $languages = Language::getShortNames();
        } catch (\Throwable $th) {
            \Log::info($th);
        }

        return $languages;
    }

    private function getDefaultLang()
    {
        $defaultLang = Language::getActiveLang() ?? 'en';

        return $defaultLang;
    }
}
