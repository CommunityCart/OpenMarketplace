<?php

namespace App\Middleware;

use App\Utility\Tables;
use Cake\Core\Configure;
use Cake\Http\BaseApplication;
use Cake\Network\Session;
use Zend\Diactoros\Response\RedirectResponse;
use App\Utility\Crypto;

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

        $usersTable = Tables::getUsersTable();

        $user_id = $request->session()->read('Auth.User.id');

        $user = $usersTable->find('all')->where(['id' => $user_id])->first();

        if($user == null && substr($request->here, 0, 14) != '/youre-invited' && $request->here != '/login' && $request->here != '/register' && $request->here != '/captcha') {
            return new RedirectResponse('/login');
        }

        if ($request->here != '/register' && substr($request->here, 0, 14) != '/youre-invited' && $request->here != '/captcha' && $request->here != '/login' && $request->here != '/display2fa' && $request->here != '/login2fa' && $user->get('2fa') == 1 && Crypto::decryptCookie($request->getCookie('2fa')) != 1) {

            return new RedirectResponse('/display2fa');
        }

        return $next($request, $response);
    }
}