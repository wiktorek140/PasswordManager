<?php

namespace App\Http\Controllers;

use App\Models\Password;
use App\Tables\PasswordTable;
use App\Utils\PasswordHelper;
use Illuminate\Http\Request;

class PasswordController extends Controller
{
    public function index() {
        if (!auth()->user()->master_password || !session()->has('master_password')) {
            return redirect(route('master.index'));
        }

        $table = (new PasswordTable())->setup();
        return view('table.password', compact('table'));
    }

    public function create() {
        return view('passwordStore');
    }

    public function store(Request $request) {
        $pass = PasswordHelper::encryptPassword($request->password);

        $request->merge([
            'user_id' => auth()->user()->id,
            'password' => $pass
        ]);

        $pass = Password::create($request->all());
        if (!$pass) {
            return back()->with(['error' => true]);
        }
        return redirect(route('password.index'));
    }

    public function destroy($id)
    {
        $passModel = Password::find($id);
        if ($passModel->user_id != auth()->user()->id){
            return redirect()->back();
        }

        $passModel->delete();
        return redirect()->back();
    }

    public function show($id) {
        $passModel = Password::find($id);

        if ($passModel->user_id != auth()->user()->id){
            return response()->json(['error' => 'Nie masz dostępu do tego elementu!']);
        }

        $result = PasswordHelper::decryptPassword($passModel->password);

        if ($result === null) {
            return response()->json(['error' => 'Wystąpił błąd z roszyfrowywaniem hasła!']);
        }

        return response()->json(['password' => $result]);
    }
}
