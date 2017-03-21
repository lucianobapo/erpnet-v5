<?php

use ErpNET\Migrates\BaseMigration;
use Illuminate\Database\Schema\Blueprint;

class CreateProvidersTable extends BaseMigration {

    protected $table = 'providers';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function upMigration()
    {
        $this->createTable(function (Blueprint $table) {
            $table->increments('id');

            /**
             * Relacionamentos entre as tabelas
             */
            $table->integer('user_id')->unsigned()->index()->nullable();

            /**
             * Campos de data
             */
            $table->timestamps();
            $table->softDeletes();

            /**
             * Mandante do Banco de dados
             */
            $table->string('mandante')->index();

            // Campos
//            $table->timestamp('start_date')->default(DB::raw('CURRENT_TIMESTAMP'))->index();
//            $table->timestamp('end_date')->default(DB::raw('CURRENT_TIMESTAMP'))->index();
            $table->string('provider')->index();
            $table->string('provider_id')->index();
//            $table->string('app_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function downMigration()
    {
        $this->dropTable();
    }
}
