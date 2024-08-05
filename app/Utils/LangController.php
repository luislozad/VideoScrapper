<?php

namespace App\Utils;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class LangController
{
    private string $lang;

    public function __construct(string $lang)
    {
        $this->lang = $lang;
    }

    public function buildResponse(string $view)
    {
        $lang = $this->lang;

        if (Auth::check()) {
            $this->saveUserLang();

            app()->setLocale($lang);
            return $this->newResponse($view);
        } else {
            app()->setLocale($lang);
            return $this->newResponse($view);
        }
    }

    private function newResponse(string $view)
    {
        $lang = $this->lang;
        $cookie = cookie('language_preference', $lang, 60 * 24 * 30);
        $response = response()->view($view);

        $response->withCookie($cookie);

        return $response;
    }

    private function saveUserLang()
    {
        $lang = $this->lang;
        $id = Auth::id();
        $user = User::find($id);

        if ($user) {
            $user->lang = $lang;
            $user->save();
        }
    }
}
