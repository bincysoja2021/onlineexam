<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class Preventrefresh
{
    public function handle(Request $request, Closure $next): Response
    {
        // Block F5/Ctrl+R behavior: track question timestamp
        $routeName = $request->route()->getName();

        // Allow refresh on certain routes (like result/thank-you)
        if (!Session::has('exam_started')) {
            Session::put('exam_started', now());
        }

        // Disqualify if a refresh attempt is detected (same route hit within 1 sec)
        $lastHit = Session::get('last_exam_activity_time');

        if ($lastHit) {
            $now = now();
            $secondsElapsed = $now->diffInSeconds($lastHit);

            if ($secondsElapsed < 1) {
                Session::flush(); // disqualify the user
                return redirect('/thank-you')->with('message', 'You were disqualified for refreshing the exam page.');
            }
        }

        Session::put('last_exam_activity_time', now());

        return $next($request);
    }
}
