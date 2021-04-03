<?php

namespace App\Tables;

use App\Models\Password;
use Illuminate\Database\Eloquent\Builder;
use Okipa\LaravelTable\Abstracts\AbstractTable;
use Okipa\LaravelTable\Table;

class PasswordTable extends AbstractTable
{
    /**
     * Main function responsible for building tables
     *
     * @return \Okipa\LaravelTable\Table
     * @throws \ErrorException
     */
    protected function table(): Table
    {
        return (new Table())->model(Password::class)
            ->routes([
                'index'   => ['name' => 'password.index'],
                'create'  => ['name' => 'password.create'],
                'destroy' => ['name' => 'password.destroy'],
                'show'    => ['name' => 'password.show'],
                'edit'    => ['name' => 'password.edit'],
            ])
            ->query(function (Builder $query) {
               $query->select('*')->where('user_id', auth()->user()->id);
            })->rowsNumber(20)
            ->activateRowsNumberDefinition(false)
            ->destroyConfirmationHtmlAttributes(fn(Password $pass) => [
                'data-confirm' => __('Jesteś pewien że chcesz ususnąć ten wpis :name ?', [
                    'name' => $pass->login
                ])
            ]);
    }

    /**
     * Table columns and definition how it should look like
     *
     * @param \Okipa\LaravelTable\Table $table
     *
     * @throws \ErrorException
     */
    protected function columns(Table $table): void
    {
        $table->column('login')->sortable()->title('Login');
        $table->column('web_address')->sortable()->title('Adres strony')->link();
        $table->column('description')->sortable()->title('Opis');
        $table->column('created_at')->sortable()->title('Data utworzenia');
        $table->column()->title('Hasło')->html(
            fn(Password $pass) => '<span class="password">********</span><span style="padding-left:12px"><a class="share-password" href="password/'. $pass->id .'"><i class="fas fa-share-square"></i></a></span>'
        );
    }
}
