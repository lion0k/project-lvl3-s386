<?php

namespace App\Http\Middleware;

use Closure;

class CheckExistProtocol
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
        if (strtolower($request->method()) === 'post') {
            $inputData = $request->all();

            if (array_key_exists('name', $inputData)) {
                if (! preg_match("~^https?://~i", $inputData[ 'name' ])) {
                    $inputData['name'] = "http://{$inputData['name']}";
                }
                $request->merge(['name' => $inputData['name']]);
            }
        }

        return $next($request);
    }
}
