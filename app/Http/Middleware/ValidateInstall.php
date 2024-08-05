<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Brotzka\DotenvEditor\DotenvEditor;
use Brotzka\DotenvEditor\Exceptions\DotEnvException;

class ValidateInstall
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $envPath = base_path('.env');

        if (file_exists($envPath)) {
            $env = new DotenvEditor();

            try {
                $isInstalled = $env->getValue('INSTALLATION_COMPLETE');
                if ($isInstalled) {
                    return redirect()->route('home');
                }
            } catch (DotEnvException $th) {
                \Log::info($th);
            }
        }

        return $next($request);
    }
}
