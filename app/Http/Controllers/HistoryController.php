<?php

namespace App\Http\Controllers;

use App\Tables\ActionsTable;
use Illuminate\Http\Request;

class HistoryController extends Controller
{
    public function index()
    {
        $table = (new ActionsTable())->setup();
        return view('table.actions', compact('table'));
    }
}
