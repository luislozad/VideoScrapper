<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PageControl extends Controller
{
    public function index(): View
    {
        return view('backend.admin.page-control');
    }
}
