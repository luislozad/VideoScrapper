<?php

namespace App\Http\Controllers\Install;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cookie;

class PreInstallController extends Controller
{
    public function index(Request $request)
    {
        $this->optimizeClear();
        $this->keyGenerate();
        $this->optimize();

        return redirect()->route('page.installer');
        // return "$data";
    }

    public function keyGenerate()
    {
        try {
            Artisan::call('key:generate');
            return response()->json([
                'error' => false,
            ]);
        } catch (\Throwable $th) {
            \Log::info($th);
            return response()->json([
                'error' => true,
            ]);
        }
    }

    public function optimize()
    {
        try {
            Artisan::call('optimize');
            return response()->json([
                'error' => false,
            ]);
        } catch (\Throwable $th) {
            \Log::info($th);
            return response()->json([
                'error' => true,
            ]);
        }
    }

    public function optimizeClear()
    {
        try {
            Artisan::call('optimize:clear');
            return response()->json([
                'error' => false,
            ]);
        } catch (\Throwable $th) {
            \Log::info($th);
            return response()->json([
                'error' => true,
            ]);
        }
    }
}
