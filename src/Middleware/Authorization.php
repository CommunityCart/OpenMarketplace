<?php

namespace App\Middleware;

use App\Utility\Tables;
use Cake\Core\Configure;
use Cake\Http\BaseApplication;
use Cake\Network\Session;

class Authorization
{
    protected $app;

    public function __construct(BaseApplication $app = null)
    {
        $this->app = $app;
    }

    public function __invoke($request, $response, $next)
    {
        // Check to see if user has 2fa enabled
        // -> Check to see if 2fa cookie == 1
        // -> else redirect to /display2fa

        return $next($request, $response);
    }
}