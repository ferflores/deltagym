<?php

use Illuminate\Database\Migrations\Migration;

class FirstReportsModelChanges extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if(!Schema::HasTable("reportes")){
			Schema::create("reportes",function($table){
				$table->increments("id");
				$table->string("nombre", 100);
				$table->string("clase", 50);
				$table->string("url");

			});
		}

		DB::table('reportes')->insert(
	        array(
	            'nombre' => 'Reporte general',
	            'clase' => '.reporteGeneral',
	            'url' => 'reporteGeneral'
	        )
    	);
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('reportes');
	}

}