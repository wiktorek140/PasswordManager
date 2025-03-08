<?php

namespace App\Http\Controllers;

use App\Models\DatachangeLog;
use App\Models\Password;
use App\Tables\DataTable;
use Illuminate\Http\Request;

class DataHistoryController extends Controller
{
    public function index()
    {
        $table = (new DataTable())->setup();
        return view('table.actions', compact('table'));
    }

    public function show($id)
    {
        Datachange::action('Restore', ['object_id' => $id]);
        $log = DatachangeLog::find($id);
        $obj = Password::find($log->object_id);
        $oldData = $obj->toArray();

        $obj->forceFill(json_decode($log->old_data, true));
        $obj->save();

        Datachange::data('Restore', $obj, $oldData);
        return back();
    }
}
