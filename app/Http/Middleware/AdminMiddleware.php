<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(
        Request $request,
        Closure $next
    ): Response {

        if (!$request->user()) {

            return redirect('/admin/login');
        }

        if (!$request->user()->role || $request->user()->role !== 'admin') {

            abort(403, 'You do not have access to this page, please contact the admin or contact this number 01303*****3 Thanks  .');
        }

        return $next($request);
    }
}
