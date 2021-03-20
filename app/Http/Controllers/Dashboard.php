<?php

namespace App\Http\Controllers;

use App\Tables\UsersTable;
use Illuminate\Http\Request;

class Dashboard extends Controller
{
    public function index()
    {
        $table = (new UsersTable())->setup();

        return view('dashboard', compact('table'));
    }

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

        session()->put('master_password', substr(hash('ripemd320',$request->master_password), 38, 32));

        return redirect(route('password.index'));
    }

}
