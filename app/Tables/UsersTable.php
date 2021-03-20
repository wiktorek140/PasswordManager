<?php

namespace App\Tables;

use App\Models\User;
use Okipa\LaravelTable\Abstracts\AbstractTable;
use Okipa\LaravelTable\Table;

class UsersTable extends AbstractTable
{
    /**
     * Configure the table itself.
     *
     * @return \Okipa\LaravelTable\Table
     * @throws \ErrorException
     */
    protected function table(): Table
    {
        return (new Table())->model(User::class)
            ->routes([
                'index'   => ['name' => 'master.index'],
            ])
            ->destroyConfirmationHtmlAttributes(fn(User $user) => [
                'data-confirm' => __('Are you sure you want to delete the line ' . $user->database_attribute . ' ?'),
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
        $table->column('id')->sortable(true)->title('ID');
        $table->column('name')->sortable()->searchable()->title('Imie');
        $table->column('email')->sortable()->searchable()->title('Email');
        $table->column('created_at')->dateTimeFormat('d/m/Y H:i')->sortable()->title('Utworzony');
        $table->column('updated_at')->dateTimeFormat('d/m/Y H:i')->sortable()->title('Zaktualizowany');
        $table->column('isHmac')->sortable()->title('Używa HMAC?');
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
