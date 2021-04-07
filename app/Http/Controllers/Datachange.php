<?php

namespace App\Http\Controllers;

use App\Models\DatachangeActions;
use App\Models\DatachangeLog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Datachange extends Controller
{

    public static function action(string $action, $additionalData = null): void
    {
        $actionModel = new DatachangeActions();
        $actionModel->user_id = auth()->user()->id;
        $actionModel->action = $action;
        $actionModel->additional_info = json_encode($additionalData);
        $actionModel->save();
    }


    public static function data(string $action, Model $model, array $oldData, $flipOrder = false): void
    {
        $dataModel = new DatachangeLog();
        $dataModel->user_id = auth()->user()->id;
        $dataModel->action = $action;
        $dataModel->table_name = $model->getTable();
        $dataModel->old_data = $flipOrder? json_encode($model->toArray()) : json_encode($oldData);
        $dataModel->new_data = $flipOrder? json_encode($oldData) : json_encode($model->toArray());
        $dataModel->object_id = $model->id;
        $dataModel->save();
    }
}
