<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller
{
    function index(Request $request): View
    {
        $languagePreference = $request->cookie('language_preference');

        return view('frontend.index');
    }
}
