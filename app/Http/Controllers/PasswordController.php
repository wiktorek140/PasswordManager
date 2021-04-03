<?php

namespace App\Http\Controllers;

use App\Models\Password;
use App\Tables\PasswordTable;
use App\Utils\PasswordUtils;
use Illuminate\Http\Request;

class PasswordController extends Controller
{
    /**
     * Create base view with table
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function index() {
        if (!auth()->user()->master_password || !session()->has('master_password')) {
            return redirect(route('master.index'));
        }

        $table = (new PasswordTable())->setup();
        return view('table.password', compact('table'));
    }

    /**
     * Create view with form for adding new password
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create() {
        return view('passwordStore');
    }

    public function store(Request $request) {
        $pass = PasswordUtils::encryptPassword($request->password);

        $request->merge([
            'user_id' => auth()->user()->id,
            'password' => $pass
        ]);

        if ($request->has('id')) {
            $pass = Password::find($request->id);
            $pass->fill($request->toArray());
            $pass->save();
        } else {
            $pass = Password::create($request->all());
        }

        if (!$pass) {
            return back()->with(['error' => true]);
        }
        return redirect(route('password.index'));
    }

    /**
     * Function that destroy password when user ask for it
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $passModel = Password::find($id);
        if ($passModel->user_id != auth()->user()->id){
            return redirect()->back();
        }

        $passModel->delete();
        return redirect()->back();
    }

    /**
     * Resturn password or proper message when fail to decode password
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id) {
        $passModel = Password::find($id);

        if ($passModel->user_id != auth()->user()->id){
            return response()->json(['error' => 'Nie masz dostępu do tego elementu!']);
        }

        $result = PasswordUtils::decryptPassword($passModel->password);

        if ($result === null) {
            return response()->json(['error' => 'Wystąpił błąd z roszyfrowywaniem hasła!']);
        }

        return response()->json(['password' => $result]);
    }


    public function edit($id) {
        $passModel = Password::find($id);
        if (!$passModel || $passModel->user_id != auth()->user()->id){
            return redirect()->back();
        }

        $passModel->password = PasswordUtils::decryptPassword($passModel->password);

        return view('passwordStore', compact('passModel'));
    }
}
