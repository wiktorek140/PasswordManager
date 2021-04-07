<?php

namespace App\Tables;

use App\Models\DatachangeActions;
use Okipa\LaravelTable\Abstracts\AbstractTable;
use Okipa\LaravelTable\Table;

class ActionsTable extends AbstractTable
{
    /**
     * Configure the table itself.
     *
     * @return \Okipa\LaravelTable\Table
     * @throws \ErrorException
     */
    protected function table(): Table
    {
        return (new Table())->model(DatachangeActions::class)
            ->routes([
                'index' => ['name' => 'history.index']
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
        $table->column('additional_info')->sortable()->searchable()->title("Dodatkowe informacje");
        $table->column('created_at')->sortable()->title("Data");
    }
}
