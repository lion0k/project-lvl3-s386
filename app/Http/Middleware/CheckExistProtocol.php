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
        if ($request->isMethod('post') && $request->has('name')) {
            $inputData = $request->all();
            $oldName = $inputData['name'];
            if (! empty($oldName) && ! preg_match("~^https?://~i", $inputData[ 'name' ])) {
                $inputData['name'] = "http://{$inputData['name']}";
            }
            $request->merge(['name' => $inputData['name'], 'oldName' => $oldName]);
        }

        return $next($request);
    }
}
