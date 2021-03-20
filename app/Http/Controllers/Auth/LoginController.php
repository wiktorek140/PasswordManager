<?php


namespace App\Http\Controllers\Auth;


use App\Http\Controllers\Controller;

use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    use AuthenticatesUsers;
    use AuthenticatesUsers {
        logout as performLogout;
    }

    public function logout(Request $request)
    {
        $this->performLogout($request);
        return redirect()->route('/login');
    }
}
