<?php

namespace App\Tables;

use App\Models\Password;
use Illuminate\Database\Eloquent\Builder;
use Okipa\LaravelTable\Abstracts\AbstractTable;
use Okipa\LaravelTable\Table;

class PasswordTable extends AbstractTable
{
    /**
     * Configure the table itself.
     *
     * @return \Okipa\LaravelTable\Table
     * @throws \ErrorException
     */
    protected function table(): Table
    {
        return (new Table())->model(Password::class)
            ->routes([
                'index'   => ['name' => 'passwords.index'],
                'create'  => ['name' => 'password.create'],
                'destroy' => ['name' => 'password.destroy'],
                'show'    => ['name' => 'password.show'],
            ])
            ->query(function (Builder $query) {
               $query->select('*')->where('user_id', auth()->user()->id);
            })
            ->destroyConfirmationHtmlAttributes(fn(Password $pass) => [
                'data-confirm' => __('Jesteś pewien że chcesz ususnąć ten wpis :name ?', [
                    'name' => $pass->login
                ])
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
        $table->column('web_address')->sortable()->searchable()->title('Adres strony')->link();
        $table->column('login')->sortable()->searchable()->title('Login')->link();
        $table->column('description')->sortable()->searchable()->title('Opis');
        $table->column('created_at')->sortable()->searchable()->title('Data utworzenia');
        $table->column()->title('Hasło')->html(fn() => '<span class="password">********</span>');
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
