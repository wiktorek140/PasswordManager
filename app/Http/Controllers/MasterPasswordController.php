<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MasterPasswordController extends Controller
{
    /**
     * Basic view with form to enter/save master password
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        return view('dashboard');
    }

    /**
     * Function responsible for storing master password or validating it during next logins
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        if (!$request->master_password) {
            return back();
        }

        $user = auth()->user();
        if (!$user->master_password) {
            $user->master_password = hash('sha512', $request->master_password);
            $user->save();
        } else if (hash('sha512', $request->master_password) != $user->master_password) {
            session()->remove('master_password');
            return back()->with(['error' => 'password error']);
        }

        // set master password as key for encrypter based on random start position
        session()->put('master_password', substr(hash('ripemd320', $request->master_password), 38, 32));

        return redirect(route('password.index'));
    }

}
