<?php

namespace App\Http\Controllers;

use App\Tables\DataTable;
use Illuminate\Http\Request;

class DataHistoryController extends Controller
{
    public function index() {
        $table = (new DataTable())->setup();
        return view('table.actions', compact('table'));
    }
}
