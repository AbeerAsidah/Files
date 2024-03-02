<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class LogRequestsAndResponses
{

    public function handle(Request $request, Closure $next)
    {
        // تسجيل الطلب الوارد
        Log::info('طلب وارد', ['request' => $request->all()]);

        // استدعاء الطلب والحصول على الاستجابة
        $response = $next($request);

        // تسجيل الاستجابة الصادرة
        Log::info('استجابة صادرة', ['response' => $response]);

        return $response;

    }
}
