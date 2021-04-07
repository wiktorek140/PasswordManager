<?php

namespace App\Tables;

use App\Models\DatachangeLog;
use Okipa\LaravelTable\Abstracts\AbstractTable;
use Okipa\LaravelTable\Table;

class DataTable extends AbstractTable
{
    /**
     * Configure the table itself.
     *
     * @return \Okipa\LaravelTable\Table
     * @throws \ErrorException
     */
    protected function table(): Table
    {
        return (new Table())->model(DatachangeLog::class)
            ->routes([
                'index' => ['name' => 'datahistory.index']
            ]);
    }

    /**
     * Configure the table columns.
     *
     * @param \Okipa\LaravelTable\Table $table
     *
     * @throws \ErrorException
     */
    protected function columns(Table $table): void
    {
        $table->column('action')->sortable()->searchable()->title("Akcja");
        $table->column('user_id')->sortable()->searchable()->title("Id użytkownika");
        $table->column('table_name')->sortable()->searchable()->title("Tabela");
        $table->column('object_id')->sortable()->searchable()->title("ID obiektu");
        $table->column('old_data')->sortable()->searchable()->title("Przed")->html(
            function (DatachangeLog $dcl) {
                $res = json_decode($dcl->old_data);
                if (isset($res->password)) {
                    $res->password = substr($res->password, 0,8) . "..." . substr($res->password, -8, 8);
                }

                return '<pre>' . print_r($res, true) . '</pre>';
            });
        $table->column('new_data')->sortable()->searchable()->title("Po")->html(
            function (DatachangeLog $dcl) {
                $res = json_decode($dcl->new_data);
                if (isset($res->password)) {
                    $res->password = substr($res->password, 0,8) . "..." . substr($res->password, -8, 8);
                }

                return '<pre>' . print_r($res, true) . '</pre>';
            });
        $table->column('created_at')->sortable()->title("Data");
    }

    /**
     * Configure the table result lines.
     *
     * @param \Okipa\LaravelTable\Table $table
     */
    protected function resultLines(Table $table): void
    {
        //
    }
}
