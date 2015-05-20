<?php

use Illuminate\Database\Migrations\Migration;

class AddActivoColumnToEgresos extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('egresos', function($table){
    		$table->boolean('activo')->default('1');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('egresos', function($table){
		    $table->dropColumn('activo');
		});
	}

}