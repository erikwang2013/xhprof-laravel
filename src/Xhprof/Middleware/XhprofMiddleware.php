<?php
declare(strict_types=1);

namespace App\Http\Middleware;

use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Aaron\Xhprof\Xhprof;

/**
 * Class StaticFile
 * @package app\middleware
 */
class XhprofMiddleware {

    public function handle(Request $request, callable $next): Response
    {
        $xhprof =config('xhprof.enable')?:false;
        $extension = extension_loaded('xhprof');
        if(false==$extension) return response()->withBody("请安装xhprof扩展");
        $redis=extension_loaded("redis");
        if(false==$redis) return response()->withBody("请安装redis扩展");
        Xhprof::$ignore_url_arr=config('xhprof.ignore_url_arr')?:"/test";
        Xhprof::$time_limit=config('xhprof.time_limit')?:0;
        Xhprof::$log_num=config('xhprof.log_num')?:1000;
        Xhprof::$view_wtred=config('xhprof.view_wtred')?:3;
        if ($xhprof && $extension) Xhprof::xhprofStart();
        $response = $next($request);
        if ($xhprof && $extension) Xhprof::xhprofStop();
        return $response;
    }
}
