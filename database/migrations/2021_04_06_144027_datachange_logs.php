<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DatachangeLogs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('datachange_log', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id');
            $table->string('action');
            $table->string('table_name');
            $table->bigInteger('object_id');
            $table->json('old_data')->nullable();
            $table->json('new_data')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
        });

        Schema::create('datachange_action', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id');
            $table->string('action');
            $table->json('additional_info')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
