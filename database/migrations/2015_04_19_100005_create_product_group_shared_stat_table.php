<?php

use ErpNET\Migrates\BaseMigration;
use Illuminate\Database\Schema\Blueprint;

class CreateProductGroupSharedStatTable extends BaseMigration {

    protected $table = 'product_group_shared_stat';

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function upMigration()
	{
        $this->createTable(function(Blueprint $table){
			$table->increments('id');
            $table->timestamps();
			$table->softDeletes();

            $table->integer('product_group_id')->unsigned()->index();
            $table->integer('shared_stat_id')->unsigned()->index();
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
