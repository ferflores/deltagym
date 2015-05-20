<?php
	class Permisos extends Eloquent {
		public $timestamps = false;
		
		protected $fillable = array('nombre','clase','rutas');

		protected $table = 'permisos';

	}
?>