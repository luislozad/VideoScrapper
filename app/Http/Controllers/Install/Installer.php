<?php

namespace App\Http\Controllers\Install;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class Installer extends Controller
{
    public function index(): View 
    {
        return view('installation.page-installer');
    }
}
