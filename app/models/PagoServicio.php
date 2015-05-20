<?php
	class PagoServicio extends Eloquent {
		public $timestamps = false;
		protected $fillable = array('idservicio','idegreso','comentario');
		protected $table = 'pagosservicios';
	}
?>