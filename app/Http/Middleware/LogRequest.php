<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Arr;

class LogRequest
{    
    public function handle($request, Closure $next)
    {
        $request->start = microtime(true);

        return $next($request);
    }

    public function terminate($request, $response)
	{
        $request->end = microtime(true);

        $this->log($request,$response);
	}

    protected function log($request, $response)
    {
        $duration = $request->end - $request->start;
        $url = $request->fullUrl();
        $method = $request->getMethod();
        $ip = $request->getClientIp();

        $responseContent = json_encode(Arr::except($response->original, 'data'));
        $log = "{$ip}: {$method}@{$url} - {$duration}ms \n".
        "Request : ".json_encode($request->all())."\n".
        "Response : {$responseContent} \n";

        Log::info($log);
    }
}