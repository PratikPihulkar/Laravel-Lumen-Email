<?php

namespace App\Http\Middleware;


use Closure;
use Illuminate\Support\Facades\Log;
use App\Models\Emp;
use App\Http\Controllers\EmailController;


class ExampleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) 
    {
        $employee = Emp::find($request->id);

        if ($employee && $employee->code === "d02") {
            return $next($request); // go to controller
        }

        return response("You are not authorized.", 403); // Return proper response instead of die()
    }
}