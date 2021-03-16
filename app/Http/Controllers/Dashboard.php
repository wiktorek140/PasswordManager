<?php

namespace App\Http\Controllers;

use App\Tables\UsersTable;
use Illuminate\Http\Request;

class Dashboard extends Controller
{
    public function index() {

        $table = (new UsersTable())->setup();

        return view('dashboard', compact('table'));
    }
}
