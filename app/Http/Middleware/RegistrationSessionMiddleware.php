<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class RegistrationSessionMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!Session::has('registration_step1')) {
            return redirect()->route('registration.create.step1')
                ->with('error', 'Silakan lengkapi data pribadi terlebih dahulu.');
        }

        return $next($request);
    }
}